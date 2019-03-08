<?php

namespace App\Model;

use Cosmos\System\Model;

class Monitor extends Model {

    private $description;

    public function __construct() {
        parent::__construct($this);
    }

    function __set($name, $value) {
        $this->$name = $value;
    }

    function __get($name) {
        return $this->$name;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    public function getQualityMonitor($sector = null, $datei = null, $datef = null) {
        return (new \App\Dao\Monitor())->getQualityMonitor($sector, $datei, $datef);
    }

    public function getQuantityMonitor($type) {
        return (new \App\Dao\Monitor())->getQuantityMonitor($type);
    }

    public function getInsecuritiesMonitorAdmin() {
        return (new \App\Dao\Monitor())->getInsecuritiesMonitorAdmin();
    }

    public function getInsecuritiesMonitorUser($user) {
        return (new \App\Dao\Monitor())->getInsecuritiesMonitorUser($user);
    }

}
