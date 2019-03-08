<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Menu extends Dao {

    private $user;
    private $result;
    private $menu;

    function __construct() {
        $this->user = \App\Model\User::getUserLoged();
        parent::__construct($this);
    }

    public function getSubMenus() {
        $this->querySubMenusForUser();
        return $this->result;
    }

    public function getMenus() {
        $this->queryMenusForUser();
        return $this->result;
    }

    private function queryMenusForUser() {

        $this->result = $this->queryBuild("SELECT m.name, m.icon, m.page FROM Menu as m
        INNER JOIN Page as p ON m.page=p.idPage
        INNER JOIN Permission as pn ON p.idPage=pn.page
        INNER JOIN User as u ON u.idUser=pn.user
        WHERE u.idUser={$this->user->getId()} AND m.parent=0 OR p.level_min=0 AND p.level_max=0
        ORDER by ord ASC");
    }

    private function querySubMenusForUser() {
        $this->result = $this->querybuild("SELECT m.name, m.icon, m.page FROM Menu as m
        INNER JOIN Page as p ON m.page=p.idPage
        INNER JOIN Permission as pn ON p.idPage=pn.page
        INNER JOIN User as u ON u.idUser=pn.user
        WHERE u.idUser={$this->user->getId()} AND m.parent={$this->menu->getId()}
        ORDER by ord ASC");
    }

}
