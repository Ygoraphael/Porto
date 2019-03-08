<?php

namespace App\Dao;

use Cosmos\System\Dao;
use App\Model\Page;

class Permission extends Dao {

    private $page;
    private $user;
    private $authorized = false;
    private $restricted = false;
    private $result;

    function __construct() {
        parent::__construct($this);
    }

    public function getAthorizedUser(Page $page) {
        $this->user = \App\Model\User::getUserLoged();
        $this->page = $page;
        $this->getPageAthorized();
        return $this->authorized;
    }

    private function getPageAthorized() {
        $parameters = [
            'user' => ['=', $this->user->getId(), 'AND'],
            'page' => ['=', $this->page->getId()]
        ];
        $object = parent::selectOne($parameters);
        if (!empty($object)) {
            $this->authorized = true;
        }
    }

    public function getRestrictedUser(Page $page) {
        $this->page = $page;
        $this->getMenuRestricted();
        return $this->restricted;
    }

    private function getMenuRestricted() {
        if (($this->page->getLevel_min() > 0) && ($this->page->getLevel_max() > 0)) {
            $this->restricted = true;
        }
    }

    public function listingAllUsers() {
        $parameters = [
            'status' => ['=', 1]
        ];
        return parent::selectAll($parameters);
    }

    public function getPermissionsUser(\App\Model\User $user) {
        $this->user = $user;
        $this->queryPermissionsUser();
        return $this->result;
    }

    private function queryPermissionsUser() {
        $this->result = $this->querybuild("SELECT p.page FROM Permission as p
        INNER JOIN User as u ON p.user=u.idUser
        INNER JOIN Page as pg ON p.page=pg.idPage
        INNER JOIN Menu as m ON pg.idPage=m.page
        WHERE u.idUser={$this->user->getId()}");
    }

    public function getDeletePermissionsUser(\App\Model\User $user) {
        $this->user = $user;
        $this->queryDeletePermissionsUser();
        return $this->result;
    }

    private function queryDeletePermissionsUser() {
        $this->result = $this->querybuild("DELETE FROM Permission WHERE user={$this->user->getId()}");
    }

}
