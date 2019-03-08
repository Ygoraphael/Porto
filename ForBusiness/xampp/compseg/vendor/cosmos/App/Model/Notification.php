<?php

namespace App\Model;

use Cosmos\System\Model;

class Notification extends Model {

    private $user;
    private $table1;
    private $value1;
    private $table2;
    private $value2;
    private $date_limit;
    private $title;
    private $description;
    private $type;

    public function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getTable1() {
        return $this->table1;
    }

    function getValue1() {
        return $this->value1;
    }

    function getTable2() {
        return $this->table2;
    }

    function getValue2() {
        return $this->value2;
    }

    function getDate_limit() {
        return $this->date_limit;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getType() {
        return $this->type;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setTable1($table1) {
        $this->table1 = $table1;
    }

    function setValue1($value1) {
        $this->value1 = $value1;
    }

    function setTable2($table2) {
        $this->table2 = $table2;
    }

    function setValue2($value2) {
        $this->value2 = $value2;
    }

    function setDate_limit($date_limit) {
        $this->date_limit = $date_limit;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setType($type) {
        $this->type = $type;
    }

    public static function listingNotificationsUser(\App\Model\User $user) {
        return (new \App\Dao\Notification)->listingNotificationsUser($user);
    }

    //**ATRIBUTION**//
    public function Atribution() {
        $this->user = filter_input(INPUT_POST, 'userIns', FILTER_SANITIZE_NUMBER_INT);
        $this->table1 = "insecurity";
        $this->value1 = filter_input(INPUT_POST, 'Insecurity', FILTER_SANITIZE_NUMBER_INT);
        $this->deleted_at = "";
        $this->date_limit = "";
        $this->title = "Insegurança por resolver";
        $this->description = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->type = "4";
        $this->insert();
    }

    //**RE-ATRIBUTION**//
    public function Re_Atribution() {
        $this->user = filter_input(INPUT_POST, 'userIns', FILTER_SANITIZE_NUMBER_INT);
        $this->deleted_at = "";
        $this->date_limit = "";
        $this->title = "Insegurança por resolver";
        $this->description = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->type = "4";
        $this->deleted = "0";
        $this->update();
    }

    //**SAVE REFUND**//
    public function SaveRefund() {
        $this->user = $this->user = User::getUserLoged()->getId();
        $this->table2 = NULL;
        $this->value2 = NULL;
        $this->deleted = "1";
        $this->deleted_at = "";
        $this->title = "Insegurança por resolver";
        $this->description = "";
        $this->update();
    }

    //**SAVE RESOLVED**//
    public function Resolved_Insecurity() {
        $this->table2 = "insecurity";
        $this->value2 = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->deleted = "1";
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->title = "Insegurança resolvida";
        $this->update();
    }

    //**RESOLVED INSECURITY FOR BOSS**//
    public function SaveClose_Insecurity() {
        $this->user = $this->user = User::getUserLoged()->getId();
        $this->table1 = "insecurity";
        $this->value1 = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->table2 = "insecurity";
        $this->value2 = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $this->deleted = "1";
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->date_limit = "";
        $this->title = "Insegurança resolvida";
        $this->description = filter_input(INPUT_POST, 'comment2', FILTER_SANITIZE_STRING);
        $this->type = "4";
        $this->insert();
    }

    public function RegisterFilter($filter) {
        return (new \App\Dao\Notification)->RegisterFilter($filter);
    }

}
