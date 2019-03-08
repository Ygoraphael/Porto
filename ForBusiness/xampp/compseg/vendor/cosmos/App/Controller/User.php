<?php

namespace App\Controller;

use Cosmos\System\Controller;

class User extends Controller {

    private $status;
    private $user;
    private $response;
    private $password;
    private $repeat_password;

    function __construct() {
        parent::__construct($this);
    }

    public function index() {
        $this->load("{$this->directory}/User");
    }

    public function NewUser() {
        $this->load("{$this->directory}/User", 'NewUser_Admin', false, false);
    }

    public function NewUserCompany() {
        $this->load("{$this->directory}/User", 'NewUser_Company', false, false);
    }

    public function edit() {
        $this->load("{$this->directory}/User", 'Edit', false, false);
    }

    public function save() {
        $this->register();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function register() {
        if (!is_null(\App\Model\Company::getCompany())) {
            $company = (new \App\Model\Company)->fetch(\App\Model\Company::getCompany()->getId());
        } else {
            $company_id = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_NUMBER_INT);
            $company = (new \App\Model\Company)->fetch($company_id);
        }

        $status_license = $this->verifyValidLicenses($company);
        if ($status_license) {
            $this->user = (new \App\Model\User());
            $this->user->register();
            if ($this->user->getMessage()->getType() == 1) {
                $this->user->setId($this->user->getMessage()->getId());
                $this->setRegisterUserLicense($company, $this->user);
            } else {
                $this->response['message'] = $this->user->getMessage()->getMessage();
                $this->response['type'] = $this->user->getMessage()->getType();
            }
        } else {
            $this->response['message'] = '%%Company does not have sufficient licenses%%.';
            $this->response['type'] = 0;
        }
    }

    private function setRegisterUserLicense(\App\Model\Company $company, \App\Model\User $user) {
        $this->user_license = new \App\Model\UserLicense();
        $this->user_license->setCompany($company->getId());
        $this->user_license->setUser($user->getId());
        $this->user_license->insert();
        if ($this->user_license->getMessage()->getType() == 1) {
            $this->setPermissions();
        }
    }

    private function setUserLicense(\App\Model\Company $company, \App\Model\User $user) {
        $this->user_license = new \App\Model\UserLicense();
        $this->user_license->setCompany($company->getId());
        $this->user_license->setUser($user->getId());
        $this->user_license->insert();
    }

    private function setResponse() {
        $this->response['message'] = '%%Registered user successfully%%!';
        $this->response['type'] = 1;
        if ($this->status) {
            $this->send_email();
        }
    }

    private function setPermissions() {
        $this->status = Permission::permission_user($this->user);
        $this->setResponse();
    }

    public function sendEmailNewUser(\App\Model\User $user) {
        $this->user = $user;
        $this->send_email();
    }

    private function send_email() {
        $link = APP_SITE_URL . "/user/confirm/{$this->user->getHash()}";

        $message = "<p>%%Hello%%, {$this->user->getName()}</p>
		<p>%%Your registration is almost complete%%.</p>
		<p>%%Click the button below to confirm your account or copy and paste the link into the browser%%.</p>
		<table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary'>
                    <tbody>
                        <tr>
                            <td align='center'>
                                <table border='0' cellpadding='0' cellspacing='0'>
                                    <tbody>
                                        <tr>
                                            <td><a href='{$link}' target='_blank'>%%Confirm Account%%</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
		</table>";

        parent::sendEmail((new \App\Model\Translate())->translater('Email confirmation'), $message, $this->user->getEMail(), $this->user->getName());
    }

    public function confirm() {
        $hash = func_get_arg(0);
        $parameters = [
            'hash' => ['=', $hash, 'AND'],
            'status' => ['=', 0]
        ];
        $user = (new \App\Model\User)->listingRegisters($parameters)[0];
        if (!empty($user)) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_password']['user'] = serialize($user);
            $this->load('User', 'Confirm', false, false);
        } else {
            \Cosmos\System\Helper::redirect('/login');
        }
    }

    public function saveedit() {
        $this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->saveUpdate();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        //porque estava isto aqui??
        //\Cosmos\System\Helper::redirect('/panel/users');
        echo json_encode($this->response);
    }

    private function saveUpdate() {
        $this->user = (new \App\Model\User())->fetch($this->id);
        $this->user->saveUpdate();
        if ($this->user->getMessage() == TRUE ) {
            if (!is_null(\App\Model\Company::getCompany())) {
                $company = (new \App\Model\Company)->fetch(\App\Model\Company::getCompany()->getId());
            } else {
                $company_id = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_NUMBER_INT);
                $company = (new \App\Model\Company)->fetch($company_id);
            }

            \App\Model\UserLicense::getDeleteUserLicenseUser($this->user);
            $this->setUserLicense($company, $this->user);

            \App\Model\Permission::getDeletePermissionsUser($this->user);
            Permission::permission_user($this->user);
			
            $this->response['type'] = 1;
            $this->response['message'] = '%%User updated successfully%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Unable to update user%%!';
        }
    }

    public function delete() {
        $this->user = (new \App\Model\User());
        $this->status = $this->user->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%User successfully deleted%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function password() {
        $this->password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $this->repeat_password = filter_input(INPUT_POST, 'repeat_password', FILTER_SANITIZE_STRING);
        if (isset($_SESSION['user_password'])) {
            $user = (new \App\Model\User)->fetch(unserialize($_SESSION['user_password']['user'])->getId());
            if (($this->password == $this->repeat_password) && !empty($this->password)) {
                $user->setPassword(\Cosmos\System\Helper::encryptPassword($this->password));
                $user->setStatus(1);
                $user->update();
                if ($user->getMessage()->getType() == 1) {
                    \Cosmos\System\Helper::my_session_start();
                    $_SESSION['message_password']['msg'] = '%%Password successfully registered%%!';
                    $_SESSION['message_password']['type'] = 1;
                    \Cosmos\System\Helper::redirect('/login');
                } else {
                    \Cosmos\System\Helper::my_session_start();
                    $_SESSION['message_password']['msg'] = '%%Could not register your password%%!';
                    $_SESSION['message_password']['type'] = 0;
                }
            } else {
                \Cosmos\System\Helper::my_session_start();
                \Cosmos\System\Helper::redirect("/user/confirm/{$user->getHash()}");
                $_SESSION['message_password']['msg'] = '%%Passwords do not match%%!';
                $_SESSION['message_password']['type'] = 0;
            }
        }
    }

    public function person() {
        $this->requiresAuthentication();
        $this->load('User', 'Person', false, false);
    }

    public function email() {
        $this->requiresAuthentication();
        $this->load('User', 'Email', false, false);
    }

    public function editmail() {
        $this->requiresAuthentication();
        if (isset($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (\Cosmos\System\Helper::validatesMail($email)) {
                $session_user = $_SESSION['user'];
                $parameters = ['email' => ['=', $email]];
                $countMail = (new \App\Model\User)->listingRegisters($parameters);
                if (count($countMail) > 0) {
                    $response['type'] = 2;
                    $response['message'] = 'Este email já está em uso.';
                } else {
                    $_SESSION['user'] = $session_user;
                    $user = (new \App\Model\User)->fetch(\App\Model\User::getUserLogged()->getId());
                    $user->setEmail($email);
                    $user->update();
                    if ($user->getMessage()->getType() == 1) {
                        $response['type'] = 1;
                        $response['message'] = '%%Email updated successfully%%.';
                    }
                    $_SESSION['user'] = $session_user;
                }
            } else {
                $response['type'] = 2;
                $response['message'] = 'Email inválido.';
            }
        }
        echo json_encode($response);
    }

    public function editpassword() {
        $this->requiresAuthentication();
        if (isset($_POST['password']) && isset($_POST['newpassword'])) {
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $new_password = filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING);
            $confirm_password = filter_var($_POST['newpassword2'], FILTER_SANITIZE_STRING);
            $password_encrypt = \Cosmos\System\Helper::encryptPassword($password);
            $status = false;
            if (strlen($new_password) < 8) {
                $response['type'] = 2;
                $response['message'] = '%%New password must contain at least 8 characters%%.';
            } else if ($new_password !== $confirm_password) {
                $response['type'] = 2;
                $response['message'] = 'As senhas não conferem.';
            } else if ($password_encrypt != (new \App\Model\User)->fetch(\App\Model\User::getUserLogged()->getId())->getPassword()) {
                $response['type'] = 2;
                $response['message'] = 'Senha atual incorreta.';
            } else {
                $status = true;
            }
            if ($status) {
                $session_user = $_SESSION['user'];
                $user = (new \App\Model\User)->fetch(\App\Model\User::getUserLogged()->getId());
                $user->setPassword(\Cosmos\System\Helper::encryptPassword($new_password));
                $user->update();
                if ($user->getMessage()->getType() == 1) {
                    $response['type'] = 1;
                    $response['message'] = '%%Password changed successfully%%.';
                }
                $_SESSION['user'] = $session_user;
            }
        }
        echo json_encode($response);
    }

    private function verifyValidLicenses(\App\Model\Company $company) {
        $license = (new \App\Model\License())->fetch($company->getLicense());
        $parameters = [
            'company' => ['=', $company->getId(), 'AND'],
            'status' => ['>=', 1, 'AND'],
            'deleted' => ['<', 1]
        ];
        $user_license = count((new \App\Model\UserLicense())->listingRegisters($parameters));
        $slot = (int) $license->getUsers_license();
        if ($slot > $user_license && $license->getStatus() == 1) {
            return true;
        } else {
            return false;
        }
    }

}
