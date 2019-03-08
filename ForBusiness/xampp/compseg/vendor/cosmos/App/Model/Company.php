<?php

namespace App\Model;

use Cosmos\System\Model;

class Company extends Model {

    private $license;
    private $status = 0;
    private $data_base;
    private $nif;
    private $phone;
    private $address;
    private $zipcode;
    private $location;
    private $country;
    private $language;

    function __construct() {
        parent::__construct($this);
    }

    function getLicense() {
        return $this->license;
    }

    function getStatus() {
        return $this->status;
    }

    function getData_base() {
        return $this->data_base;
    }

    function getNif() {
        return $this->nif;
    }

    function getPhone() {
        return $this->phone;
    }

    function getAddress() {
        return $this->address;
    }

    function getZipcode() {
        return $this->zipcode;
    }

    function getLocation() {
        return $this->location;
    }

    function getCountry() {
        return $this->country;
    }

    function getLanguage() {
        return $this->language;
    }

    function setLicense($license) {
        $this->license = $license;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setData_base($data_base) {
        $this->data_base = $data_base;
    }

    function setNif($nif) {
        $this->nif = $nif;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setLanguage($language) {
        $this->language = $language;
    }

    public function register() {
        $this->nif = filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_STRING);
        $this->phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $this->address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $this->zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
        $this->location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
        $this->data_base = filter_input(INPUT_POST, 'data_base', FILTER_SANITIZE_STRING);
        $this->language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_NUMBER_INT);
        $this->insert();
    }

    public function createDatabaseCompany($user, $config) {
        return (new \App\Dao\Company())->createDatabaseCompany($this, $user, $config);
    }

    public function getConfig() {
        return (new \App\Dao\Config($this))->getConfig();
    }

    public static function getDataBase() {
        return (new \App\Dao\Company())->getDataCompany()->getData_base();
    }

    public static function getCompany() {
        return (new \App\Dao\Company())->getCompany();
    }

    public function saveUpdate() {
        $this->nif = filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_STRING);
        $this->phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $this->address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $this->zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
        $this->location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
        $this->data_base = filter_input(INPUT_POST, 'data_base', FILTER_SANITIZE_STRING);
        $this->language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_NUMBER_INT);
        $this->update();
    }

}
