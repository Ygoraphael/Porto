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
	$count = $database->count("account", ["id" => $_POST["id"]]);
	
	if($count > 0) {
		$database->update("account", [
			"name" => $_POST["name"],
			"desc" => $_POST["desc"],
			"ip_dns" => $_POST["ip_dns"],
			"port" => $_POST["port"],
			"type" => $_POST["type"],
			"db_name" => $_POST["db_name"],
			"db_user" => $_POST["db_user"],
			"db_pw" => $_POST["db_pw"]
		], ["id" => $_POST["id"]]);
		
		echo "Atualizado Com Sucesso";
	}
	else {
		$database->insert("account", [
			"id" => $database->max("account", "id")+1,
			"name" => $_POST["name"],
			"desc" => $_POST["desc"],
			"ip_dns" => $_POST["ip_dns"],
			"port" => $_POST["port"],
			"type" => $_POST["type"],
			"db_name" => $_POST["db_name"],
			"db_user" => $_POST["db_user"],
			"db_pw" => $_POST["db_pw"]
		]);
		
		echo "Introduzido com sucesso";
	}
?>