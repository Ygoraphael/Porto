<?php

namespace Cosmos\System;

use PDO;
use PDOException;

abstract class Database extends PDO {

    private $index;
    private static $handle = null;
    private static $select_fields;
    private static $query;
    private static $fields_values = array();
    private static $indexNameAsId = null;
    protected static $table;
    protected static $class;
    protected static $get_methods = array();
    protected static $indexName = false;
    protected static $isUnique = false;
    protected static $fieldsIsUnique = array();
    protected static $data;
    protected $response;
    protected $create_database;
    protected $querybuild;

    function __construct() {
        try {
            $dns = self::$data->getDriver() . ':dbname=' . self::$data->getDbName() . ';host=' . self::$data->getDbHost();
            if (self::$handle == null) {
                $dbh = parent::__construct($dns, self::$data->getUser(), self::$data->getPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$handle = $dbh;
                return self::$handle;
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @param mixed $data
     */
    protected function setData($data) {
        $this->data = $data;
    }

    function __clone() {
        
    }

    function __destruct() {
        self::$handle = null;
        self::$select_fields;
        self::$fields_values = array();
        self::$indexNameAsId = null;
        self::$get_methods = array();
        self::$indexName = false;
        self::$isUnique = false;
        self::$fieldsIsUnique = array();
    }

    /**
     * @param boolean $indexName
     */
    public static function setIndexName(bool $indexName) {
        self::$indexName = $indexName;
    }

    protected function getTable() {
        return self::$table;
    }

    protected function verifyIsUnique($object): array {
        $fieldsUnique = self::getParametersUnique($object);
        $response['type'] = count(self::selectAll($fieldsUnique)) == 0 ? true : false;
        if (!$response['type']) {
            return $this->alertFieldsUnique($fieldsUnique);
        }
        return $response;
    }

    protected function alertFieldsUnique(array $fields): array {
        foreach ($fields as $field => $key) {
            $response['field'] = $field;
            $response['value'] = $key[1];
            $response['type'] = false;
        }
        return $response;
    }

    protected function getIndex(): string {
        if (self::$indexName) {
            return $this->index;
        }
        return 'id' . ucfirst(self::getTable());
    }

    protected function setIndex(string $index) {
        $this->index = $index;
    }

    protected function getIndexTableName() {
        if (!self::$indexName) {
            self::$indexNameAsId = ', id' . ucfirst(self::getTable()) . ' as id ';
        } else {
            self::$indexNameAsId = ', ' . self::getIndex() . ' as id ';
        }
        return self::$indexNameAsId;
    }

    public function getColumns() {
        $columns = array();
        $attributes = (new \ReflectionClass(self::$class))->getDefaultProperties();

        foreach ($attributes as $column => $attribute) {
            $field = $column;
            if ($column == 'id' && self::getIndexTableName()) {
                $field = self::getIndex();
            }
            $columns[] = $field;
            self::$get_methods[':' . $field] = Helper::treatAttributeForGet($column);
        }
        return implode(", ", $columns);
    }

    private function setQuery(string $query) {
        self::$query = $query;
    }

    private function setFields(array $fields) {
        self::$query = $fields;
    }

    private function setFieldsAndValues(array $fields_values) {
        self::$fields_values = $fields_values;
    }

    private function setSelectQuery(array $parameters = null) {
        $query_string = 'select ';
        $fields_select = '';
        if (!empty(self::$select_fields)) {
            $fields_select = implode(',', self::$select_fields);
        } else {
            $fields_select .= '*';
        }
        $fields_select .= self::getIndexTableName();
        $query_string .= $fields_select;
        $query_string .= ' from ' . self::getTable();
        if (!empty($parameters)) {
            $query_string_param = self::getQueryParameters($parameters);
            $query_string .= $query_string_param['sql'];
            self::setFields($query_string_param['name_fields']);
            self::setFieldsAndValues($query_string_param['value_fields']);
        }
        self::setQuery($query_string);
    }

    private function getParametersUnique($object) {
        $parameters = [];
        $and = ' OR ';
        $i = 0;
        $j = count(self::$fieldsIsUnique);
        if ($j == 0) {
            self::$fieldsIsUnique[] = 'id';
        }
        foreach (self::$fieldsIsUnique as $field) {
            $i++;
            if ($j == 0) {
                $and = '';
            } else {
                if ($i == $j) {
                    $and = '';
                }
            }
            $getMethod = Helper::treatAttributeForGet($field);
            $field = $field == 'id' ? 'id' . ucfirst(self::getTable()) : $field;
            $parameters[$field] = ['=', $object->$getMethod(), $and];
        }

        return $parameters;
    }

    protected function setFieldSelect(array $fields): array {
        self::$select_fields = $fields;
    }

    private function setInsertQuery() {
        $query_string = 'insert into ' . self::getTable();
        $query_string .= ' (' . self::getColumns() . ') ';
        $query_string .= 'values (:' . str_replace(', ', ', :', self::getColumns()) . ')';
        self::setQuery($query_string);
    }

    private function setUpdateQuery() {
        $query_string = 'update ' . self::getTable();
        $query_string .= ' set ';
        $fields_columns = explode(', ', self::getColumns());
        $fields = array();
        foreach ($fields_columns as $field) {
            $fields[$field] = $field . '=:' . $field;
        }
        $query_string .= implode(', ', $fields);
        $query_string .= ' where ' . $fields[self::getIndex()];
        self::setQuery($query_string);
    }

    /**
     * @param $object
     * @return array
     */
    protected function update($object) {
        self::setUpdateQuery();
        $query = self::prepare(self::$query);
        self::$get_methods;
        foreach (self::$get_methods as $field => $method) {
            if (is_object($object->$method())) {
                $query->bindValue($field, $object->$method()->getId());
            } else {
                $query->bindValue($field, $object->$method());
            }
        }
        $query->execute();
        $errorInfo = $query->errorInfo();
        if ($errorInfo[0] != 0) {
            error_log(print_r(self::$query, true));
            error_log(print_r($errorInfo[2], true));
        }
        $response['type'] = $query->rowCount() > 0 ? true : false;
        $response['field'] = "";
        $response['value'] = "";
        $response['unique'] = "";
        self::__destruct();
        return $response;
    }

    protected function queryBuild(string $query) {
        $this->querybuild = $query;
        return $this->executeQueryBuild();
    }

    private function executeQueryBuild() {
        $query = self::prepare($this->querybuild);
        $query->execute();
        $errorInfo = $query->errorInfo();
        if ($errorInfo[0] != 0) {
            error_log(print_r($this->querybuild, true));
            error_log(print_r($errorInfo[2], true));
        }
        if (!empty(self::$class)) {
            $query->setFetchMode(PDO::FETCH_CLASS, self::$class);
        } else {
            $query->setFetchMode(PDO::FETCH_OBJ);
        }
        return $query->fetchAll();
    }

    private function getQueryParameters(array $parameters): array {
        $query_str = ' where';
        $value_fields = array();
        $name_fields = array();

        foreach ($parameters as $field => $parameter) {
            $query_str .= ' ' . $field;
            $name_fields[] = $field;
            foreach ($parameter as $key => $value) {
                if ($key == 1) {
                    if( $parameter[0] == 'IS NULL' ) {
                        $fields_query_str = ' ';
                    }
                    else if( $parameter[0] == 'BETWEEN' ) {
                        $fields_query_str = ' ' . "'" . $value . "'";
                    }
                    else {
                        $value_fields[':' . $field] = $value;
                        $fields_query_str = ':' . $field;
                    }
                } elseif ($key == 2) {
                    $fields_query_str = substr_replace($value, ' ', 0, 0);
                } else {
                    $fields_query_str = ' ' . $value;
                }
                $query_str .= $fields_query_str;
            }
        }
        $query_parameters = ['sql' => $query_str, 'name_fields' => $name_fields, 'value_fields' => $value_fields];
        return $query_parameters;
    }

    protected function selectAll(array $parameters = null) {
        self::setSelectQuery($parameters);
        $query = self::prepare(self::$query);
        $query->execute(self::$fields_values);
        $errorInfo = $query->errorInfo();
        if ($errorInfo[0] != 0) {
            error_log(print_r(self::$query, true));
            error_log(print_r($errorInfo[2], true));
        }
        if (!empty(self::$class)) {
            $query->setFetchMode(PDO::FETCH_CLASS, self::$class);
        } else {
            $query->setFetchMode(PDO::FETCH_OBJ);
        }
        $result = $query->fetchAll();
        self::__destruct();
        return $result;
    }

    protected function selectOne(array $parameters = null) {
        self::setSelectQuery($parameters);
        $query = self::prepare(self::$query);
        $query->execute(self::$fields_values);
        $errorInfo = $query->errorInfo();
        if ($errorInfo[0] != 0) {
            error_log(print_r(self::$query, true));
            error_log(print_r($errorInfo[2], true));
        }
        if (!empty(self::$class)) {
            $query->setFetchMode(PDO::FETCH_CLASS, self::$class);
        } else {
            $query->setFetchMode(PDO::FETCH_OBJ);
        }
        $result = $query->fetch();

        self::__destruct();
        return $result;
    }

    protected function insert($object): array {
        self::setInsertQuery();
        $query = self::prepare(self::$query);
        self::$get_methods;
        foreach (self::$get_methods as $field => $method) {
            if (is_object($object->$method())) {
                $query->bindValue($field, $object->$method()->getId());
            } else {
                $query->bindValue($field, $object->$method());
            }
        }
        $query->execute();
        $errorInfo = $query->errorInfo();
        if ($errorInfo[0] != 0) {
            error_log(print_r(self::$query, true));
            error_log(print_r($errorInfo[2], true));
        }

        $idObject = (int) $this->lastInsertId();
        $response = $idObject > 0 ? true : false;
        self::__destruct();
        return ['response' => $response, 'id' => $idObject];
    }

    protected function countRows(array $parameters = null): int {
        self::setSelectQuery($parameters);
        $query = self::prepare(self::$query);
        $query->execute(self::$fields_values);
        $errorInfo = $query->errorInfo();
        if ($errorInfo[0] != 0) {
            error_log(print_r(self::$query, true));
            error_log(print_r($errorInfo[2], true));
        }
        return $query->rowCount();
    }

    protected function createDatabase() {
        $query = self::prepare($this->create_database);
        return $query->execute();
    }

}
