<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Factory extends Controller {

    private $factory;
    private $response;

    function __construct() {
        parent::__construct($this);
    }

    public function new_group() {
        (new PermissionGroup)->new_group();
    }

    public function new_factory() {
        $this->load("{$this->directory}/Factory", 'New', false, false);
    }

    public function save() {
        $this->helperSaveFactory();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
    }

    private function helperSaveFactory() {
        $this->factory = new \App\Model\Factory();
        $this->factory->register();
        if ($this->factory->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Factory registered successfully%%!';
            $this->response['type'] = 1;
        } else {
            $this->response['message'] = '%%Could not register this factory%%!';
            $this->response['type'] = 0;
        }
    }

    public function edit() {
        $this->load("{$this->directory}/Factory", 'Edit', false, false);
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
        $this->factory = (new \App\Model\Factory())->fetch($this->id);
        $this->factory->saveUpdate();
        if ($this->factory->getMessage() == TRUE) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Factory Updated Successfully%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Unable to upgrade factory%%!';
        }
    }

    public function delete() {
        $this->factory = (new \App\Model\Factory());
        $this->status = $this->factory->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Factory successfully deleted%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function listing() {
        $this->load("{$this->directory}/Factory", 'Listing', false, false);
    }

}
