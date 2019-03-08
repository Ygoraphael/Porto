<?php

namespace App\Model;

class UserLogged {

    private $idUser;
    private $email;
    private $session_id;

    public function __construct(User $user) {
        $this->idUser = $user->getId();
        $this->email = $user->getEmail();
        $this->session_id = session_id();
    }

    public function getEmail() {
        return $this->email;
    }

    public function getId() {
        return $this->idUser;
    }

    public function getSession_id() {
        return $this->session_id;
    }

}
