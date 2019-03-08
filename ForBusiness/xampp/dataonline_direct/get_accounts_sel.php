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
	
	$output = "";
	
	foreach($data as $row) {
		$output .= "<option value='".$row['id']."'>".$row['name']."</option>";
	}
	
	echo $output;
?>