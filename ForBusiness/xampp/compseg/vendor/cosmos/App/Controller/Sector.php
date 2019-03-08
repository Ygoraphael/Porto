<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Sector extends Controller {

    private $sector;
    private $response;

    function __construct() {
        parent::__construct($this);
    }

    public function new_sector() {
        $this->load("{$this->directory}/Sector", 'New', false, false);
    }

    public function save() {
        $this->helperSaveSector();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
		echo json_encode($this->response);
    }

    private function helperSaveSector() {
        $this->sector = new \App\Model\Sector();
        $this->sector->register();
        if ($this->sector->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Sector registered successfully%%!';
            $this->response['type'] = 1;
        } else {
            $this->response['message'] = '%%Could not register this sector%%!';
            $this->response['type'] = 0;
        }
    }

    public function edit() {
        $this->load("{$this->directory}/Sector", 'Edit', false, false);
    }
	
	public function listing2(){
		$this->load("{$this->directory}/Sector", 'Listing', false, false);
	}
	
	public function listing3(){
		$this->load("{$this->directory}/Sector", 'Listing2', false, false);
	}

    public function saveedit() {
        $this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->saveUpdate();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function saveUpdate() {
        $this->sector = (new \App\Model\Sector())->fetch($this->id);
        $this->sector->saveUpdate();
        if ($this->sector->getMessage() == TRUE) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Sector Updated successfully%%!';
        } else {
            $this->response['type'] = 0;
            $this->response['message'] = '%%Unable to update sector%%!';
        }
    }

    public function delete() {
        $this->sector = (new \App\Model\Sector());
        $this->status = $this->sector->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Sector deleted successfully%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

}
