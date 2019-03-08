<?php

namespace App\Model;

use Cosmos\System\Model;

class User extends Model {

    private $email;
    private $code;
    private $password;
    private $name;
    private $last_name;
    private $user_type;
    private $status = 0;
    private $hash;
    private $loged = false;
    private $profile;
    private $factory;

    function __construct() {
        parent::__construct($this);
    }

    function getEmail() {
        return $this->email;
    }

    function getCode() {
        return $this->code;
    }

    function getPassword() {
        return $this->password;
    }

    function getName() {
        return $this->name;
    }

    function getUser_type() {
        return $this->user_type;
    }

    function getStatus() {
        return $this->status;
    }

    function getHash() {
        return $this->hash;
    }

    function getLast_name() {
        return $this->last_name;
    }
    
    function getProfile() {
        return $this->profile;
    }
    
    function getFactory() {
        return $this->factory;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUser_type($user_type) {
        $this->user_type = $user_type;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setHash($hash) {
        $this->hash = $hash;
    }
    
    function setProfile($profile) {
        $this->profile = $profile;
    }
    
    function setFactory($factory) {
        $this->factory = $factory;
    }

    public function fetchUserByHash() {
        return (new \App\Dao\User())->fetchUserByHash($this);
    }
    
    public function fetchUserByEmailOrCode() {
        return (new \App\Dao\User())->fetchUserByEmailOrCode($this);
    }

    public function getLoged() {
        return $this->loged;
    }

    public function panel() {
        return 'user';
    }

    public function setLoged() {
        if (isset($_SESSION['user_loged'])) {
            $this->loged = true;
        }
    }

    public static function getUserLoged() {
        if (isset($_SESSION['user_loged'])) {
            return unserialize($_SESSION['user_loged']);
        }
        return false;
    }

    public static function verifyCompany() {
        return UserLicense::getLisence(self::getUserLoged());
    }
    
    public static function verifyCompanyById($id) {
        return UserLicense::getLisence((new \App\Model\User())->fetch($id));
    }

    public function register() {
        $response['type'] = 2;
        if (!$this->fetchUserByEmailOrCode()) {
            $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $this->last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
            $this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $this->code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
            $this->user_type = filter_input(INPUT_POST, 'user_type', FILTER_SANITIZE_STRING);
            $this->profile = filter_input(INPUT_POST, 'profile', FILTER_SANITIZE_NUMBER_INT);
			$this->factory = filter_input(INPUT_POST, 'factory', FILTER_SANITIZE_NUMBER_INT);
            $this->hash = \Cosmos\System\Helper::createHash($this->email);
            return $this->insert();
        }
        return $response;
    }

    public static function getAllUsers() {
        return (new \App\Dao\User())->listingAllUsers();
    }

    public static function getCompanyUsers($company) {
        return (new \App\Dao\User())->listingUserForCompany($company);
    }

    public static function listingUsersCompany() {
        return (new \App\Dao\User())->listingUsersCompany();
    }

    public function saveUpdate() {
        $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $this->user_type = filter_input(INPUT_POST, 'user_type', FILTER_SANITIZE_STRING);
        $this->profile = filter_input(INPUT_POST, 'profile', FILTER_SANITIZE_STRING);
        $this->factory = filter_input(INPUT_POST, 'factory', FILTER_SANITIZE_STRING);
        $this->update();
    }

    public function selectAdminCompany($company) {
        return (new \App\Dao\User)->selectAdminCompany($company)[0];
    }

}
