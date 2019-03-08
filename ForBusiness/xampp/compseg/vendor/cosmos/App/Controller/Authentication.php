<?php

/**
 * Product: Meteor
 * Created by Cosmos Digital.
 * Developer: Jeferson Kaefer
 * Date: 20/09/2016
 * Time: 06:30
 */

namespace App\Controller;

use App\Model\AuthenticationCurrent;

class Authentication {

    private $key;
    private $user_name;
    private $user_id;
    private $mail;
    private $ip;
    private $level;
    private static $user;
    private static $isAuthenticatedUser = false;

    /**
     * @return mixed
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail) {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getIp() {
        return $this->ip;
    }

    public function setIp() {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return mixed
     */
    public function getUserName() {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUsername($user_name) {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level) {
        $this->level = $level;
    }

    public function verifyIfUserExists(string $mail): array {
        self::$user = (new \Meteor\Model\User())->fetchUserByMail($mail);
        if (is_object(self::$user)) {
            $this->setDataAuthenticate(self::$user);
            return ['response' => true, 'mail' => $this->getMail()];
        }
        return ['response' => false, 'messagem' => '%%User not found%%.'];
    }

    private function setDataAuthenticate(\App\Model\User $user) {
        $this->setMail($user->getMail());
        $this->setUserId($user->getId());
        $this->setUserName($user->getUsername());
        $this->setIp();
        $this->setKey(self::getKeySessionGenerate($this->getMail()));
        $_SESSION['authenticate'] = serialize($this);
    }

    public function setUserAuthenticate(string $password) {
        self::$user = (new \App\Model\User())->fetchUserByMail(self::getDataAuthenticate()->getMail());
        if ((is_object(self::$user)) && (md5($password) == self::$user->getPassword())) {
            $auth = (new AuthenticationCurrent())->fetchByUser(self::$user);
            if (!$auth) {
                $auth = new AuthenticationCurrent();
                $auth->setIdUser(self::$user->getId());
                $auth->setKeySession(self::getKeySessionGenerate(self::$user->getMail()));
                $auth->setIp($_SERVER['REMOTE_ADDR']);
                $auth->setOnline(1);
                $auth->setNameUser(self::$user->getName());
                if ($auth->insert()) {
                    self::setMail(self::$user->getMail());
                    $this->setDataAuthenticate(self::$user);
                    return json_encode(['url' => '/user/panel', 'signup' => true]);
                }
            }
            $auth->setIdUser(self::$user->getId());
            $auth->setKeySession(self::getKeySessionGenerate(self::$user->getMail()));
            $auth->setIp($_SERVER['REMOTE_ADDR']);
            $auth->setOnline(1);
            $auth->setNameUser(self::$user->getName());
            if ($auth->update()) {
                self::setMail(self::$user->getMail());
                $this->setDataAuthenticate(self::$user);
                return json_encode(['url' => '/user/panel', 'signup' => true]);
            }
        }
        return false;
    }

    private static function getIsAuthenticated(): bool {
        if (isset($_SESSION['authenticate'])) {
            if (self::getDataAuthenticate()->getKey() == self::getKeySessionGenerate(self::getDataAuthenticate()->getMail())) {
                return true;
            }
            session_unset();
        }
        return false;
    }

    public static function getDataAuthenticate() {
        return unserialize($_SESSION['authenticate']);
    }

    public static function isAuthenticated(): bool {
        return self::getIsAuthenticated();
    }

    public static function getKeySessionGenerate(string $mail): string {
        return md5(APP_SALT . date('d-m-y H') . $mail . $_SERVER['REMOTE_ADDR']);
    }

}
