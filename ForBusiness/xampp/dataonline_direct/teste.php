<?php 
	include("classes/config.php");
	include("classes/medoo.min.php");
	include("classes/sqlserver.php");
	include("classes/slots.php");
	include("classes/graph.php");
	include("classes/table.php");
	//include("header.php");
?>

<?php
	error_reporting(E_ALL);

	$service_port = 9090;
	$address = gethostbyname('127.0.0.1');

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	// if ($socket === false) {
		// echo "socket_create() failed: reason: " . 
		// socket_strerror(socket_last_error()) . "\n";
	// }

	// echo "Attempting to connect to '$address' on port '$service_port'...<br>";
	$result = socket_connect($socket, $address, $service_port);
	// if ($result === false) {
		// echo "socket_connect() failed.\nReason: ($result) " . 
		// socket_strerror(socket_last_error($socket)) . "<br>";
	// }

	$msg = "select Description, RetailPrice1 from Items limit 5";
	
	$in = urlencode($msg) . "\r\n\r\n";
	$out = '';

	// echo "Sending HTTP HEAD request...<br>";
	socket_write($socket, $in, strlen($in));
	// echo "OK.<br>";

	// echo "Reading response:<br><br>";
	$result = "";
	
	while ( $out = socket_read($socket, 2048) ) {
		$result .= $out;
	}
	
	echo print_r(json_decode(urldecode( $result )));

	socket_close($socket);
?>

<?php
	include("footer.php");
?>