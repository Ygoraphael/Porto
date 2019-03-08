<?php

namespace Cosmos\System;

abstract class Model {

    protected $id;
    protected $created_at;
    protected $deleted_at;
    protected $deleted = 0;
    private static $object;
    private static $class;
    private static $instanceDAO;
    private static $message;

    function __construct($object) {
        self::$object = $object;
        self::$class = get_class($object);
    }

    public function getId() {
        return $this->id;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function getDeleted_at() {
        return $this->deleted_at;
    }

    function getDeleted() {
        return $this->deleted;
    }

    function setDeleted_at($deleted_at) {
        $this->deleted_at = $deleted_at;
    }

    function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    public function setId(int $id = null) {
        $this->id = $id;
    }

    private static function getInstanceDAO() {
        $instanceDAO = str_replace("\\Model\\", "\\Dao\\", self::$class);
        self::$instanceDAO = new $instanceDAO();
        return self::$instanceDAO;
    }

    public function listingRegisters(array $parameters = null) {
        $object = self::getInstanceDAO()->findRegisters($parameters);
        return $object != false ? $object : self::setMessage(false, "Nenhum registro encontrado!", 1);
    }

    public function fetch(int $index) {
        $object = self::getInstanceDAO()->fetchObj($index);
        return $object != false ? $object : self::setMessage(false, "Objeto não encontrado!", 1);
    }

    public function insert() {
        $this->created_at = (new \DateTime)->format('Y-m-d H:i:s');
        $reason = self::getInstanceDAO()->insertNewObject($this);
        $response = false;
        $object = null;
        $message = "Registo não realizado, tente mais tarde!";
        $type = 0;
        if ($reason['response']) {
            $response = true;
            $object = $reason['id'];
            $message = "Dados registados com sucesso!";
            $type = 1;
        } elseif (!$reason['unique']) {
            $response = false;
            $message = "O {$reason['field']} <b>{$reason['value']}</b> já existe, altere.";
            $type = 2;
        }
        self::setMessage($response, $message, $type, $object);
    }

    public function update() {
        $reason = self::getInstanceDAO()->updateObject($this);
        $response = false;
        $object = null;
        $message = "Objeto não atualizado, tente mais tarde!";
        $type = 0;
        if ($reason['type']) {
            $response = true;
            $message = "Dados atualizados com sucesso!";
            $type = 1;
        } elseif (!$reason['unique']) {
            $response = false;
            $message = "O {$reason['field']} <b>{$reason['value']}</b> já existe, altere.";
            $type = 2;
        }
        self::setMessage($response, $message, $type, $object);
    }

    public static function setMessage(bool $response, string $message, int $type, int $id = null) {
        self::$message = new Exception($response, $message, $type, $id);
    }

    public static function getMessage(): Exception {
        return self::$message ?? new Exception(false, "Não há mensagens!");
    }

    public function delete() {
        $this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $object = self::getInstanceDAO()->fetchObj($this->id);
        $object->setDeleted(1);
        $object->setDeleted_at((new \DateTime)->format('Y-m-d H:i:s'));
        return self::getInstanceDAO()->updateObject($object);
    }

}
