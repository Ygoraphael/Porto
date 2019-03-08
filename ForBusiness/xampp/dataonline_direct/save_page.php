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
	$count = $database->count("page", ["id" => $_POST["id"]]);
	
	if($count > 0) {
		$database->update("page", [
			"id_account" => $_POST["id_account"],
			"num" => $_POST["num"],
			"style" => $_POST["style"]
		], ["id" => $_POST["id"]]);
		
		echo "Atualizado Com Sucesso";
	}
	else {
		$database->insert("slot", [
			"id" => $database->max("slot", "id")+1,
			"id_account" => $_POST["id_account"],
			"num" => $_POST["num"],
			"style" => $_POST["style"]
		]);
		
		echo "Introduzido com sucesso";
	}
?>