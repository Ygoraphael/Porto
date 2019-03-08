<?php
	include '../classes/userauth.class.php';
	include("../classes/medoo.min.php");
	
	function log_write($str) {
		$t = fopen("tiago.txt", "a");
		fwrite($t, print_r( $str , true ) . "\n");
		fclose($t);
	}

	if ( isset($_POST["slot"]) ) {
		
		$database = new medoo("dataonline");
		
		$dados = json_decode( $_POST["data"] );
		foreach( $dados as $tudo ) {
			foreach( $tudo as $linha ) {
				$query = "insert into slot_data(status, id_account, slot, val01, val02, val03, val04, val05, val06, val07, val08, val09, val10) values (";
				$query .= "1, 1, " . $_POST["slot"] . ", ";
				$total_campos = 0;
				
				foreach( $linha as $campo ) {
					$query .= "'".trim($campo)."', ";
					$total_campos++;
				}
				
				while ($total_campos < 10) {
					$query .= "'', ";
					$total_campos++;
				}
				
				$query = substr($query, 0, strlen($query)-2) . ")";
				$database->query($query);
			}
		}
		
		$query = "delete from slot_data where slot = " . $_POST["slot"] . " and id_account = 1 and status = 0";
		$database->query($query);
		
		$query = "update slot_data set status = 0 where slot = " . $_POST["slot"] . " and id_account = 1";
		$database->query($query);
	}
	
	$array = array("success" => "True");
	echo json_encode( $array );
?>