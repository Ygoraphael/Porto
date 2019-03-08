<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Profile extends Controller {

    private $profile;
    private $response;

    function __construct() {
        parent::__construct($this);
    }

    public function new_group() {
        (new PermissionGroup)->new_group();
    }

    public function new_profile() {
        $this->load("{$this->directory}/Profile", 'New', false, false);
    }

    public function save() {
        $this->helperSaveProfile();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function helperSaveProfile() {
        $this->profile = new \App\Model\Profile();
        $this->profile->register();
        if ($this->profile->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Profile successfully saved%%!';
            $this->response['type'] = 1;
        } else {
            $this->response['message'] = '%%Could not save profile%%!';
            $this->response['type'] = 0;
        }
    }

    public function edit() {
        $this->load("{$this->directory}/Profile", 'Edit', false, false);
    }

    public function saveedit() {
        $this->saveUpdate();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function saveUpdate() {
        $this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->profile = (new \App\Model\Profile())->fetch($this->id);
        $this->profile->saveUpdate();
        if ($this->profile->getMessage() == TRUE) {
            \App\Model\ProfileMonitor::getDeleteProfileMonitors($this->profile);
            Profilemonitor::profile_monitor($this->profile);
            
            $this->response['type'] = 1;
            $this->response['message'] = '%%Profile updated successfully%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Unable to update profile%%!';
        }
    }

    public function delete() {
        $this->profile = (new \App\Model\Profile());
        $this->status = $this->profile->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Profile deleted successfully%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function listing() {
        $this->load("{$this->directory}/Profile", 'Listing', false, false);
    }

}
