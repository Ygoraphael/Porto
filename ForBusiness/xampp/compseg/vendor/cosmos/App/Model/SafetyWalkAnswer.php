<?php

namespace App\Model;

use Cosmos\System\Model;

class SafetyWalkAnswer extends Model {

    private $user;
    private $safetywalk;
    private $sector;
    private $comment;
    private $userfollow;

    public function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getSafetyWalk() {
        return $this->safetywalk;
    }
    
    function getSector() {
        return $this->sector;
    }
    
    function getComment() {
        return $this->comment;
    }
    
    function getUserFollow() {
        return $this->userfollow;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSafetyWalk($safetywalk) {
        $this->safetywalk = $safetywalk;
    }
    
    function setSector($sector) {
        $this->sector = $sector;
    }
    
    function setComment($comment) {
        $this->comment = $comment;
    }
    
    function setUserFollow($userfollow) {
        $this->userfollow = $userfollow;
    }

}