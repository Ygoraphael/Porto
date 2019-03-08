<?php

namespace Cosmos\System;

class Registry {

    private $user;
    private $password;
    private $db_name;
    private $driver;
    private $db_host;

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(string $user) {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getDbName() {
        return $this->db_name;
    }

    /**
     * @param mixed $db_name
     */
    public function setDbName(string $db_name) {
        $this->db_name = $db_name;
    }

    /**
     * @return mixed
     */
    public function getDriver() {
        return $this->driver;
    }

    /**
     * @param mixed $driver
     */
    public function setDriver($driver) {
        $this->driver = $driver;
    }

    /**
     * @return mixed
     */
    public function getDbHost() {
        return $this->db_host;
    }

    /**
     * @param mixed $db_host
     */
    public function setDbHost($db_host) {
        $this->db_host = $db_host;
    }

}
