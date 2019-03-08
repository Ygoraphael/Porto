<?php
	include '../classes/userauth.class.php';
	include("../classes/medoo.min.php");
	
	function log_write($str) {
		$t = fopen("tiago.txt", "a");
		fwrite($t, print_r( $str , true ) . "\n");
		fclose($t);
	}

	if ( isset($_POST["slot"]) ) {
		
		$account = 3;
		
		//log_write(urldecode($_POST["data"]));
		
		$database = new medoo("dataonline");
		
		$dados = json_decode( urldecode($_POST["data"]) );
		$lordem = 0;
		foreach( $dados as $tudo ) {
			foreach( $tudo as $linha ) {
				$query = "insert into slot_data(status, id_account, slot, lordem, val01, val02, val03, val04, val05, val06, val07, val08, val09, val10) values (";
				$query .= "1, $account, " . $_POST["slot"] . ", " . $lordem . ", ";
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
				$lordem += 1;
			}
		}
		
		$query = "delete from slot_data where slot = " . $_POST["slot"] . " and id_account = $account and status = 0";
		$database->query($query);
		
		$query = "update slot_data set status = 0 where slot = " . $_POST["slot"] . " and id_account = $account";
		$database->query($query);
	}
	
	$array = array("success" => "True");
	echo json_encode( $array );
?>