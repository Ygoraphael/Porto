<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Login extends Controller {

    private $username;
    private $password;
    private $user;

    function __construct() {
        parent::__construct($this);
    }

    public function index() {
        $this->load('Login', false, false, false);
    }

    public function recovery() {
        $this->load('Login', 'Recovery', false, false);
    }

    public function resetpw() {
        if (func_num_args()) {
            $hash = (string) func_get_arg(0);
            $_GET['recover_hash'] = $hash;
            $this->load('Login', 'ResetPassword', false, false);
        } else {
            \Cosmos\System\Helper::redirect('/login/recovery');
        }
    }

    public function changepw() {
        $this->password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $this->password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
        $this->hash = filter_input(INPUT_POST, 'hash', FILTER_SANITIZE_STRING);

        if ($this->password != $this->password2 && !empty($this->password)) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%Passwords do not match%%!';
            $_SESSION['user_message']['type'] = 0;
            return \Cosmos\System\Helper::redirect("/login/resetpw/{$this->hash}");
        } else if( $this->analyzePassword($this->password) ) {
            return \Cosmos\System\Helper::redirect("/login/resetpw/{$this->hash}");
        } else {
            $user = (new \App\Model\User);
            $user->setHash($this->hash);
            $this->user = $user->fetchUserByHash();

            $this->user->setPassword(\Cosmos\System\Helper::encryptPassword($this->password));
            $this->user->update();

            \Cosmos\System\Helper::my_session_start();
            if ($this->user->getMessage()->getType() == 1) {
                $_SESSION['message_password']['msg'] = '%%Password changed successfully%%!';
                $_SESSION['message_password']['type'] = 1;
            } else {
                $_SESSION['message_password']['msg'] = '%%Could not change your password%%!';
                $_SESSION['message_password']['type'] = 0;
            }

            return \Cosmos\System\Helper::redirect('/login');
        }
    }

    public function verifyrecover() {
        $this->username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $this->logInUser();
        $this->EmailRecoverUserPassword();
    }

    public function logInTo() {
        $this->username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $this->password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $this->logInUser();
        $this->authenticateUser();
    }

    private function analyzePassword($password) {
        $valid = 0;
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (strlen($password) < 5) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%Password must contain at least 5 characters in length%%!';
            $_SESSION['user_message']['type'] = 0;
            $valid++;
        }
        else if (!$uppercase) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%Password must contain an uppercase character%%!';
            $_SESSION['user_message']['type'] = 0;
            $valid++;
        }
        else if (!$lowercase) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%Password must contain an lowercase character%%!';
            $_SESSION['user_message']['type'] = 0;
            $valid++;
        }
        else if (!$number) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%Password must contain a number%%!';
            $_SESSION['user_message']['type'] = 0;
            $valid++;
        }
        
        return $valid;
    }

    private function logInUser() {
        $user = (new \App\Model\User);
        $user->setEmail($this->username);
        $user->setCode($this->username);
        $this->user = $user->fetchUserByEmailOrCode();
    }

    private function EmailRecoverUserPassword() {
        if (is_object($this->user) && $this->user->getStatus() != 0) {
            $this->sendEmailRecoverPassword();
        } else {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%No user found%%!';
            $_SESSION['user_message']['type'] = 0;
        }
        return \Cosmos\System\Helper::redirect('/login/recovery');
    }

    private function sendEmailRecoverPassword() {

        $link = APP_SITE_URL . "/login/resetpw/{$this->user->getHash()}";

        $message = "<p>%%Hello%%, {$this->user->getName()}</p>
		<p>%%Click the button below to reset your password or copy and paste the link into the browser%%.</p>
		<table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary'>
                    <tbody>
                        <tr>
                            <td align='center'>
                                <table border='0' cellpadding='0' cellspacing='0'>
                                    <tbody>
                                        <tr>
                                            <td><a href='{$link}' target='_blank'>%%Reset Password%%</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
		</table>";

        parent::sendEmail('%%Email confirmation%%.', $message, $this->user->getEMail(), $this->user->getName());

        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['info'] = '%%Please check your email to reset password%%!';
        $_SESSION['user_message']['type'] = 1;
        return \Cosmos\System\Helper::redirect('/login/recovery');
    }

    private function authenticateUser() {
        if (is_object($this->user) && ($this->user->getPassword() == \Cosmos\System\Helper::encryptPassword($this->password))) {
            $this->user->setLoged();
            $this->createdSession();
        } elseif (is_object($this->user) && $this->user->getStatus() == 0) {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%You need to verify your account%%!';
            $_SESSION['user_message']['type'] = false;
        } else {
            \Cosmos\System\Helper::my_session_start();
            $_SESSION['user_message']['info'] = '%%Login or password invalid%%!';
            $_SESSION['user_message']['type'] = false;
        }
        return \Cosmos\System\Helper::redirect('/panel');
    }

    private function createdSession() {
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_loged'] = serialize($this->user);
        if (isset($_SESSION['user_loged'])) {
            return \Cosmos\System\Helper::redirect('/panel');
        }
    }

}
