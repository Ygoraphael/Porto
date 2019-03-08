<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Category extends Controller {

    private $category;
    private $response;

    function __construct() {
        parent::__construct($this);
    }

    public function new_group() {
        (new PermissionGroup)->new_group();
    }

    public function new_category() {
        $this->load("{$this->directory}/Category", 'New', false, false);
    }

    public function save() {
        $this->helperSaveCategory();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function helperSaveCategory() {
        $this->category = new \App\Model\Category();
        $this->category->register();
        if ($this->category->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Category successfully recorded%%!';
            $this->response['type'] = 1;
        } else {
            $this->response['message'] = '%%Could not save category%%!';
            $this->response['type'] = 0;
        }
    }

    public function edit() {
        $this->load("{$this->directory}/Category", 'Edit', false, false);
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
        $this->category = (new \App\Model\Category())->fetch($this->id);
        $this->category->saveUpdate();
        if ($this->category->getMessage() == TRUE) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Category successfully updated%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Could not update category%%!';
        }
    }

    public function delete() {
        $this->category = (new \App\Model\Category());
        $this->status = $this->category->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Category deleted successfully%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function listing() {
        $this->load("{$this->directory}/Category", 'Listing', false, false);
    }

}
