<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Company extends Controller {

    private $id;
    private $license;
    private $name;
    private $status;
    private $company;
    private $company_id;
    private $config;
    private $user;
    private $user_id;
    private $user_name;
    private $user_lastname;
    private $user_email;
    private $user_license;
    private $permissions;

    function __construct() {
        parent::__construct($this);
    }

    public function index() {
        $this->load("{$this->directory}/Company");
	}
	
    public function new_company() {
        $this->load("{$this->directory}/Company", 'New', false, false);
    }

    public function edit() {
        $this->load("{$this->directory}/Company", 'Edit', false, false);
    }

    public function listing() {
        $this->load("{$this->directory}/Company", 'Listing', false, false);
    }

    public function delete() {
        $this->company = (new \App\Model\Company());
        $this->status = $this->company->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Company deleted successfully%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function save() {
        $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->user_name = filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING);
        $this->user_lastname = filter_input(INPUT_POST, 'user-lastname', FILTER_SANITIZE_STRING);
        $this->user_email = filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_STRING);
        
        $this->registerLicense();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function register() {
        $this->company = (new \App\Model\Company());
        $this->company->setLicense($this->license);
        $this->company->register();
        if ($this->company->getMessage()->getType() == 1) {
            $this->company_id = $this->company->getMessage()->getId();
            $this->config = new \App\Model\Config();
            $this->config->setName($this->name);
            $this->registerAdministrator();
        }
    }

    private function registerAdministrator() {
        $this->user = new \App\Model\User();
        $this->user->setName($this->user_name);
        $this->user->setLast_name($this->user_lastname);
        $this->user->setEmail($this->user_email);
        $this->user->setCode(\Cosmos\System\Helper::createCode());
        $this->user->setHash(\Cosmos\System\Helper::createHash($this->user->getEmail()));
        $this->user->setUser_Type(2);
        $this->user->setProfile(2);
        $this->user->insert();
        if ($this->user->getMessage()->getType() == 1) {
            $this->user_id = $this->user->getMessage()->getId();
            $this->setRegisterUserLicense();
        }
    }

    private function setPermissions() {
        $this->status = false;
        $this->permissions = \App\Model\Page::getPagesAdministrator();
        foreach ($this->permissions as $page) {
            $permission = new \App\Model\Permission();
            $permission->setUser($this->user_id);
            $permission->setPage($page->getId());
            $permission->insert();
            if ($permission->getMessage()->getType() == 1) {
                $this->status = true;
            }
        }
        if ($this->status) {
            (new \App\Controller\User())->sendEmailNewUser($this->user);
            $this->company->createDatabaseCompany($this->user, $this->config);
            $this->response['type'] = 1;
            $this->response['message'] = '%%Successfully registered company%%!';
        }
    }

    private function setRegisterUserLicense() {
        $this->user_license = new \App\Model\UserLicense();
        $this->user_license->setCompany($this->company_id);
        $this->user_license->setUser($this->user_id);
        $this->user_license->insert();
        if ($this->user_license->getMessage()->getType() == 1) {
            $this->setPermissions();
        }
    }

    private function registerLicense() {
        $this->license = new \App\Model\License();
        $this->license->register();
        if ($this->license->getMessage()->getType() == 1) {
            $this->license = $this->license->getMessage()->getId();
            $this->register();
        }
    }

    public function saveedit() {
        $this->saveUpdate();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
    }

    private function saveUpdate() {
        $this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->company = (new \App\Model\Company())->fetch($this->id);
        $this->company->saveUpdate();
        if ($this->company->getMessage() == true) {
            $this->license = (new \App\Model\License)->fetch($this->company->getLicense());
            $this->license->updateRegisters();
            $this->response['type'] = 1;
            $this->response['message'] = '%%Company updated successfully%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Unable to update company%%!';
        }
    }

}
