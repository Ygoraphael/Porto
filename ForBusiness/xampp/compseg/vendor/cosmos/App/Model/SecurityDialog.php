<?php

namespace App\Model;

use Cosmos\System\Model;

class SecurityDialog extends Model {

    private $thema;
    private $first_text;
    private $second_text;
    private $image;
    private $code;
    private $profile;

    function __construct() {
        parent::__construct($this);
    }

    function getCode() {
        return $this->code;
    }
    
    function getImage() {
        return $this->image;
    }
    
    function getThema() {
        return $this->thema;
    }

    function getFirst_text() {
        return $this->first_text;
    }

    function getSecond_text() {
        return $this->second_text;
    }
    
    function getProfile() {
        return $this->profile;
    }

    function setCode($code) {
        $this->code = $code;
    }
    
    function setImage($image) {
        $this->image = $image;
    }
    
    function setThema($thema) {
        $this->thema = $thema;
    }

    function setFirst_text($first_text) {
        $this->first_text = $first_text;
    }

    function setSecond_text($second_text) {
        $this->second_text = $second_text;
    }
    
    function setProfile($profile) {
        $this->profile = $profile;
    }

    public function register($name_encryp) {
        $this->code = \Cosmos\System\Helper::createCode();
        $this->thema = filter_input(INPUT_POST, 'thema', FILTER_SANITIZE_STRING);
        $this->first_text = filter_input(INPUT_POST, 'first_text', FILTER_SANITIZE_STRING);
        $this->second_text = filter_input(INPUT_POST, 'second_text', FILTER_SANITIZE_STRING);
        $this->profile = filter_input(INPUT_POST, 'profile', FILTER_SANITIZE_STRING);
		$this->image = $name_encryp;
        $this->insert();
    }

    public function saveUpdate($name_encryp) {
        $this->thema = filter_input(INPUT_POST, 'thema', FILTER_SANITIZE_STRING);
        $this->first_text = filter_input(INPUT_POST, 'first_text', FILTER_SANITIZE_STRING);
        $this->second_text = filter_input(INPUT_POST, 'second_text', FILTER_SANITIZE_STRING);
        $this->profile = filter_input(INPUT_POST, 'profile', FILTER_SANITIZE_STRING);
		$this->image = $name_encryp;
        $this->update();
    }

}