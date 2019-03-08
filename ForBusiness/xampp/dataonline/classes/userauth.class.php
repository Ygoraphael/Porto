<?php

/*
 * Hi,
 * This is a simple user authentication script. It allows
 * you to easily manage login system. You can see examples
 * in "demo" folder. By the way, thank you for choosing
 * my script :)
 * 
 * Author: Damian "Xayan" Stepien
 * E-mail: xayannn[at]gmail[dot]com
 * 
 * 100% copyright-free: you can modify this script,
 * use with no limitations and share with whoever
 * you want. Why? Because infoanarchism, that's why.
 * 
 * Version: 1.0
 */

class UserAuthentication {

    private $config = array(
        'database' => array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'pass' => 'tml',
            'db' => 'dataonline',
            'table' => 'users', // in what table is users' data stored?
            'fields' => array(// in what fields can necessary data be found?
                'login' => 'login', // login, such as nickname or e-mail address
                'password' => 'pass', // password, hashed or not
                'salt' => 'wV6kWcSSMLeftNE', // password's salt, if you don't hash passwords or don't salt them leave it empty
                'session_id' => 'sid' // field with session's ID, for security reasons
            )
        ),
        'hash' => 'md5', // method of hashing, simply a name of PHP function, example: if you use md5($pass) simply type md5; if you don't hash passwords - leave empty
        'start_session' => true // change to false if you start PHP session manually
    );
    private $connection;

    function __construct() {
        $this->connection = new mysqli($this->config['database']['host'], $this->config['database']['user'], $this->config['database']['pass'], $this->config['database']['db']);
        if ($this->connection->connect_error)
            throw new Exception("Database connection failed (error #" . $this->connection->connect_errno . ": " . $this->connection->connect_error . ")");
        if ($this->config['start_session'] and !session_start())
            throw new Exception("Unable to start a session");
        if (strlen($this->config['hash']) > 0 && !is_callable($this->config['hash']))
            throw new Exception("Incorrect hashing function");
        if (mysqli_num_rows($this->connection->query("SHOW TABLES LIKE '" . $this->config['database']['table'] . "'")) == 0)
            throw new Exception("Table '" . $this->config['database']['table'] . "' not found in database '" . $this->config['database']['db'] . "'");

        $fields = $this->connection->query("SHOW COLUMNS FROM " . $this->config['database']['table']);
        $found = array_fill(0, strlen($this->config['database']['fields']['salt'] == 0) ? 3 : 4, false);
        while ($field = mysqli_fetch_assoc($fields)):
            switch ($field['Field']):
                case $this->config['database']['fields']['login']:
                    $found[0] = true;
                case $this->config['database']['fields']['password']:
                    $found[1] = true;
                case $this->config['database']['fields']['salt']:
                    $found[2] = true;
                case $this->config['database']['fields']['session_id']:
                    if (strlen($this->config['database']['fields']['salt']) > 0)
                        $found[3] = true;
            endswitch;
        endwhile;
        if (in_array(false, $found))
            throw new Exception("At least one of specified fields was not found in table '" . $this->config['database']['table'] . "'");
    }

    public function isLoggedIn() {
        if (isset($_SESSION['userauth_login'])) {
            $user_q = $this->connection->query("SELECT * FROM " . $this->config['database']['table'] . " WHERE " . $this->config['database']['fields']['login'] . " = '" . $this->connection->escape_string($_SESSION['userauth_login']) . "'");
            if(mysqli_num_rows($user_q) == 1) {
                $user = mysqli_fetch_assoc($user_q);
                if($user[$this->config['database']['fields']['session_id']] == session_id())
                    return true;
            }
        }
        return false;
    }

    public function logIn($login, $password) {
        if (isset($_SESSION['userauth_login']))
            unset($_SESSION['userauth_login']);
        $user_q = $this->connection->query("SELECT * FROM " . $this->config['database']['table'] . " WHERE " . $this->config['database']['fields']['login'] . " = '" . $this->connection->escape_string($login) . "'");
        if (mysqli_num_rows($user_q) == 1) {
            $user = mysqli_fetch_assoc($user_q);
            $pass = @$user[$this->config['database']['fields']['salt']] . $password;
            if (strlen($this->config['hash']) >= 1)
                $pass = call_user_func($this->config['hash'], $pass);

            if ($pass == $user[$this->config['database']['fields']['password']]) {
                $_SESSION['userauth_login'] = $user[$this->config['database']['fields']['login']];
                $this->connection->query("UPDATE " . $this->config['database']['table'] . " SET " . $this->config['database']['fields']['session_id'] . " = '" . session_id() . "' WHERE " . $this->config['database']['fields']['login'] . " = '" . $user[$this->config['database']['fields']['login']] . "'");
                return true;
            }
        }
        return false;
    }
    
    public function logOut() {
        if($this->isLoggedIn()) {
            unset($_SESSION['userauth_login']);
            return true;
        }
        return false;
    }

    public function getLogin() {
        return $_SESSION['userauth_login'];
    }
}

?>
