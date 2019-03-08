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
	$count = $database->count("slot", ["id" => $_POST["id"]]);
	
	if($count > 0) {
		$database->update("slot", [
			"id_account" => $_POST["id_account"],
			"num" => $_POST["num"],
			"query" => $_POST["query"],
			"field1" => $_POST["field1"],
			"field2" => $_POST["field2"],
			"field3" => $_POST["field3"],
			"field4" => $_POST["field4"],
			"title" => $_POST["title"],
			"type" => $_POST["type"],
			"model" => $_POST["model"],
			"width" => $_POST["width"],
			"height" => $_POST["height"],
			"label1" => $_POST["label1"],
			"label2" => $_POST["label2"],
			"label3" => $_POST["label3"],
			"label4" => $_POST["label4"],
			"format1" => $_POST["format1"],
			"format2" => $_POST["format2"],
			"format3" => $_POST["format3"],
			"format4" => $_POST["format4"],
			"page" => $_POST["page"],
			"link" => $_POST["link"],
			"order" => $_POST["order"],
			"style" => $_POST["style"],
			"class" => $_POST["class"]
		], ["id" => $_POST["id"]]);
		
		echo "Atualizado Com Sucesso";
	}
	else {
		$database->insert("slot", [
			"id" => $database->max("slot", "id")+1,
			"id_account" => $_POST["id_account"],
			"num" => $_POST["num"],
			"query" => $_POST["query"],
			"field1" => $_POST["field1"],
			"field2" => $_POST["field2"],
			"field3" => $_POST["field3"],
			"field4" => $_POST["field4"],
			"title" => $_POST["title"],
			"type" => $_POST["type"],
			"model" => $_POST["model"],
			"width" => $_POST["width"],
			"height" => $_POST["height"],
			"label1" => $_POST["label1"],
			"label2" => $_POST["label2"],
			"label3" => $_POST["label3"],
			"label4" => $_POST["label4"],
			"format1" => $_POST["format1"],
			"format2" => $_POST["format2"],
			"format3" => $_POST["format3"],
			"format4" => $_POST["format4"],
			"page" => $_POST["page"],
			"link" => $_POST["link"],
			"order" => $_POST["order"],
			"style" => $_POST["style"],
			"class" => $_POST["class"]
		]);
		
		echo "Introduzido com sucesso";
	}
?>