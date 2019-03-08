<?php

namespace App\Model;

use Cosmos\System\Model;

class Insecurity extends Model {

    private $resumo;
    private $description;
    private $company;
    private $factory;
    private $sector;
    private $user;
    private $img;
    private $status;
    private $comment;
    private $resolved_at;

    function __construct() {
        parent::__construct($this);
    }

    function getStatus() {
        return $this->status;
    }

    function getResumo() {
        return $this->resumo;
    }

    function getDescription() {
        return $this->description;
    }

    function getCompany() {
        return $this->company;
    }

    function getFactory() {
        return $this->factory;
    }

    function getSector() {
        return $this->sector;
    }

    function getUser() {
        return $this->user;
    }

    function getImg() {
        return $this->img;
    }

    function getComment() {
        return $this->comment;
    }

    function getResolved_at() {
        return $this->resolved_at;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setResumo($resumo) {
        $this->resumo = $resumo;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCompany($company) {
        $this->company = $company;
    }

    function setFactory($factory) {
        $this->factory = $factory;
    }

    function setSector($sector) {
        $this->sector = $sector;
    }

    function setuser($user) {
        $this->user = $user;
    }

    function setImg($img) {
        $this->img = $img;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    function setResolved_at($resolved_at) {
        $this->resolved_at = $resolved_at;
    }

    public function register($name_encryp) {
        $this->resumo = filter_input(INPUT_POST, 'Resumo', FILTER_SANITIZE_STRING);
        $this->description = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->company = filter_input(INPUT_POST, 'company2', FILTER_SANITIZE_NUMBER_INT);
        $this->factory = filter_input(INPUT_POST, 'factory', FILTER_SANITIZE_NUMBER_INT);
        $this->sector = filter_input(INPUT_POST, 'sector', FILTER_SANITIZE_NUMBER_INT);
        $this->user = "";
        $this->img = $name_encryp;
        $this->comment = '[ ' . $this->user = User::getUserLoged()->getName() . " " . $this->user = User::getUserLoged()->getLast_name() . ' ]  ' . date('Y-m-d H:i:s') . '+' . filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->resolved_at = "";
        $this->status = 0;
        $this->insert();
    }

    public function listing() {
        return (new \App\Dao\Insecurity)->listing();
    }

    //**ATRIBUTION INSECURITY **//	
    public function Atribution() {
        $this->user = filter_input(INPUT_POST, 'userIns', FILTER_SANITIZE_NUMBER_INT);
        $this->comment = filter_input(INPUT_POST, 'comment2', FILTER_SANITIZE_STRING) . '+[ ' . $this->user = User::getUserLoged()->getName() . " " . $this->user = User::getUserLoged()->getLast_name() . ' ]  ' . date('Y-m-d H:i:s') . '+' . filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->status = "4";
        $this->update();
    }

    //**SAVE REFUND**//
    public function SaveRefund() {
        $this->comment = filter_input(INPUT_POST, 'comment2', FILTER_SANITIZE_STRING) . '+[ ' . $this->user = User::getUserLoged()->getName() . " " . $this->user = User::getUserLoged()->getLast_name() . ' ]  ' . date('Y-m-d H:i:s') . '+' . filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->resolved_at = "";
        $this->status = "0";
        $this->update();
    }

    //**SAVE RESOLVED**//
    public function Resolved_Insecurity() {
        $this->comment = filter_input(INPUT_POST, 'comment2', FILTER_SANITIZE_STRING) . '+[ ' . $this->user = User::getUserLoged()->getName() . " " . $this->user = User::getUserLoged()->getLast_name() . ' ]  ' . date('Y-m-d H:i:s') . '+' . filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $this->resolved_at = date('Y-m-d H:i:s');
        $this->status = "3";
        $this->update();
    }

    //**RESOLVED INSECURITY FOR BOSS**//
    public function SaveClose_Insecurity() {
        $this->comment = filter_input(INPUT_POST, 'comment2', FILTER_SANITIZE_STRING) . '+[ ' . $this->user = User::getUserLoged()->getName() . " " . $this->user = User::getUserLoged()->getLast_name() . ' ]  ' . date('Y-m-d H:i:s') . '+' . filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        ;
        $this->resolved_at = date('Y-m-d H:i:s');
        $this->status = "3";
        $this->update();
    }

    public function RegisterFilter($filter) {
        return (new \App\Dao\Insecurity)->RegisterFilter($filter);
    }

}
