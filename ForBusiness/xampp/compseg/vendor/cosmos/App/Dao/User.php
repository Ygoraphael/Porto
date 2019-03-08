<?php

namespace App\Dao;

use Cosmos\System\Dao;

class User extends Dao {

    private $result;
    private $company;

    function __construct() {
        parent::$fieldsIsUnique = ['email', 'code'];
        parent::__construct($this);
    }

    public function fetchUserByHash(\App\Model\User $user) {
        $parameters = [
            'hash' => ['=', $user->getHash()]
        ];

        $object = parent::selectOne($parameters);
        return $object ?? false;
    }
    
    public function fetchUserByEmailOrCode(\App\Model\User $user) {
        $parameters = [
            'email' => ['=', $user->getEmail(), 'OR'],
            'code' => ['=', $user->getCode()]
        ];

        $object = parent::selectOne($parameters);
        return $object ?? false;
    }

    public function listingAllUsers() {
        $parameters = [
            'status' => ['=', 1]
        ];
        return parent::selectAll($parameters);
    }

    public function listingUserForCompany(\App\Model\Company $company) {
        $this->company = $company;
        $this->queryListingUserForCompany();
        return $this->result;
    }

    public function selectAdminCompany(\App\Model\Company $company) {
        $this->company = $company;
        $this->querySelectAdminCompany();
        return $this->result;
    }

    public function listingUsersCompany() {
        $this->querySelectUsersCompany();
        return $this->result;
    }

    private function queryListingUserForCompany() {
        $this->result = $this->querybuild("SELECT u.idUser as user, c.idCompany as company FROM User as u 
        INNER JOIN UserLicense as ul ON u.idUser=ul.user
        INNER JOIN Company as c ON ul.company=c.idCompany
        WHERE c.idCompany={$this->company->getId()} AND u.deleted != 1 AND ul.status=1");
    }

    private function querySelectAdminCompany() {
        $this->result = $this->querybuild("SELECT u.idUser as id, u.name as name, u.last_name as last_name, u.email as email 
        FROM UserLicense as ul
        INNER JOIN Company as c ON ul.company=c.idCompany
        INNER JOIN User as u ON ul.user=u.idUser
        WHERE u.user_type=2 AND c.idCompany={$this->company->getId()}");
    }

    private function querySelectUsersCompany() {
        $this->result = $this->querybuild("SELECT u.*, c.data_base company, c.idCompany idCompany, u.idUser id
		FROM User as u
		LEFT JOIN UserLicense as ul ON u.idUser=ul.user
		INNER JOIN Company as c ON ul.company=c.idCompany
		WHERE u.deleted < 1
		");

        foreach ($this->result as &$user) {
            $this->result2 = $this->querybuild("select name db_name from " . $user->company . ".Config");
            $user->company = $this->result2[0]->db_name;
        }
    }

}
