<?php

class SQLServer {
	//SQLServer
	public $port;
	public $server;
	public $database;
	public $user;
	public $password;
	public $connection;
	
	public function __construct() {
		$this->port = "";
		$this->server = "127.0.0.1\SQLEXPRESS";
		if (strlen($this->port) > 0 ) 
			$this->server = $this->server . ", " . $this->port;
		$this->database = "FULLSPORT";
		$this->user = "sa";
		$this->password = "sa123";
		
		$this->connect();
	}
	
	public function connect() {
		$this->connection = odbc_connect("Driver={SQL Server};Server=$this->server;Database=$this->database;", $this->user, $this->password);
		if (!$this->connection) { 
			die( print_r( sqlsrv_errors(), true));
		}
	}
	
	public function GetData($query) {
		$rs = odbc_exec($this->connection, $query);
		$data = array();
		
		if( odbc_num_rows($rs) > 0) {
			while( $row = odbc_fetch_array($rs) ) {
				$row = $this->arrayUtf8Enconde($row);
				$data[] = $row;
			}
		}
		odbc_free_result($rs);
		return $data;
	}
	
	public function ExecQuery($query) {
		odbc_exec($this->connection, $query);
	}
	
	public function arrayUtf8Enconde(array $array) {
		$novo = array();
		foreach ($array as $i => $value) {
			if (is_array($value)) {
				$value = arrayUtf8Enconde($value);
			} 
			elseif (!mb_check_encoding($value, 'UTF-8')) {
				$value = utf8_encode($value);
			}
			$novo[$i] = $value;
		}
		return $novo;
	}
}

?>