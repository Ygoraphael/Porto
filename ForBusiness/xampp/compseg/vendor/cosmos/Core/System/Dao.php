<?php

namespace Cosmos\System;

abstract class Dao extends Database {

    protected $set_db;
    private static $classDao;
    protected $name_db;

    function __construct($class, string $table = null, $index = null) {
        self::setClass($class);
        self::setTable($table);
        $this->setUpDataBase();
        parent::__construct();
    }

    protected function setUpDataBase() {
        session_write_close();
        $registry = new Registry();
        switch ($this->set_db) {
            case 'company':
                $registry->setDriver('mysql');
                $registry->setDbHost('127.0.0.1');
                $registry->setDbName($this->name_db);
                $registry->setUser('root');
                $registry->setPassword('tml');
                break;
            default:
                $registry->setDriver('mysql');
                $registry->setDbHost('127.0.0.1');
                $registry->setDbName('ichooses_main');
                $registry->setUser('root');
                $registry->setPassword('tml');
        }
        parent::$data = $registry;
    }

    protected function setFieldsIsUnique(array $fields) {
        parent::$fieldsIsUnique = $fields;
    }

    protected function getFieldsIsUnique(): array {
        return self::$fieldsIsUnique;
    }

    protected function getClass(): string {
        $class = str_replace("\\Dao\\", "\\Model\\", get_class(self::$classDao));
        parent::$class = $class;
        return $class;
    }

    public function insertNewObject($object): array {
        $verifyIsUnique = parent::verifyIsUnique($object);
        if ($verifyIsUnique['type']) {
            return parent::insert($object);
        } else {
            $verifyIsUnique['unique'] = false;
            return $verifyIsUnique;
        }
    }

    public function updateObject($object): array {
        return parent::update($object);
    }

    private function setClass($class) {
        self::$classDao = $class;
    }

    public function recordsCount(array $parameters = null): int {
        return parent::countRows($parameters);
    }

    public function findRegisters(array $parameters = null) {
        $object = parent::selectAll($parameters);
        return $object ?? false;
    }

    private function setTable($table) {
        if (is_null($table)) {
            $class = explode('\\', self::getClass());
            $table = end($class);
        }
        parent::$table = $table;
    }

    public function fetchObj(int $index) {
        $parameters = [self::getIndex() => ['=', $index]];
        $object = parent::selectOne($parameters);
        return $object ?? false;
    }

}
