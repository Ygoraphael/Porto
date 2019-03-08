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
	$result = $database->delete("slot", ["id" => $_POST["id"]]);
	
	if($result)
		echo "Slot apagada com sucesso";
	else
		echo "Erro ao apagar slot. Tente novamente mais tarde";
?>