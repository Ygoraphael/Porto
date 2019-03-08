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
	$data = $database->select( "slot", "*", [ "ORDER" => ["page ASC", "order ASC"], "id_account" => $_POST["id"] ] );

	$output = "<thead><tr><th>Id</th><th>Account</th><th>Slot</th><th>Page</th><th>Order</th></tr></thead>";
	
	foreach($data as $row) {
		$output .= "<tr>
						<td>".$row['id']."</td>
						<td>".$row['id_account']."</td>
						<td>".$row['num']."</td>
						<td>".$row['page']."</td>
						<td>".$row['order']."</td>
					</tr>";
	}
	
	echo $output;
?>