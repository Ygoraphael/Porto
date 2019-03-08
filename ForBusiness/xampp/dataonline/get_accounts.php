<?php 
	include("classes/config.php");
	include("classes/sqlserver.php");
	include("classes/medoo.min.php");
	include("classes/slots.php");
	include("classes/graph.php");
	include("classes/table.php");
?>
<?php
	$database = new medoo("dataonline");
	$data = $database->select("account", "*");
	
	$output = "<thead><tr><th>Id</th><th>Account</th></tr></thead>";
	
	foreach($data as $row) {
		$output .= "<tr><td>".$row['id']."</td><td>".$row['name']."</td></tr>";
	}
	
	echo $output;
?>