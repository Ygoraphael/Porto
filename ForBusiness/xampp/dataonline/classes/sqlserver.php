<?php
	
	$conf = new Conf();
	$connection = odbc_connect("Driver={SQL Server};Server=$conf->server;Database=$conf->database;", $conf->user, $conf->password);

	if (!$connection) { 
		die( print_r( sqlsrv_errors(), true)); 
	}
?>