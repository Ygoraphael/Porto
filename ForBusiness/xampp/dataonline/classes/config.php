<?php

class Conf {
	//SQLServer
	public $port;
	public $server;
	public $database;
	public $user;
	public $password;
	
	public function __construct() {
		$this->port = "15637";
		$this->server = "novoscanais.no-ip.info, " . $this->port;
		$this->database = "NOVOSCANAIS";
		$this->user = "rc";
		$this->password = "rc123";
	}

	// public function __get( $name = null ) {
		// return $this->self[$name];
	// }

	// public function add( $name = null, $enum = null ) {
		// if( isset($enum) )
		// $this->self[$name] = $enum;
		// else
		// $this->self[$name] = end($this->self) + 1;
	// }
}

?>