<?php 
	$auth = new UserAuthentication();

	if ($auth->isLoggedIn()) {
		$login = $auth->getLogin();
?>
		<body>
			<div id="container">
				<?php
					$database = new medoo("dataonline");
					$account = $_GET["a"];
					$page = isset($_GET["p"]) ? $_GET["p"] : 1;
					$edit = isset($_GET["e"]) ? $_GET["e"] : 'f';
					
					$page_style = $database->select( "page", "style", ["AND" => ["id_account" => $account, "num" => $page]] );
					if (sizeof( $page_style )>0)
						echo "<style>body { ".$page_style[0]." }</style>";
					
					$all_slots = $database->select( "slot", "*", ["AND" => ["id_account" => $account, "page" => $page], "ORDER" => "order ASC",] );
					$connectionType = $database->select("account", "*", ["id" => $account]);
					
					foreach($all_slots as $s) {
						echo "<div class='item item".$s["num"]." ".$s["class"]."' data-fixSize='0' data-cellW=".$s["width"]." data-cellH=".$s["height"]." style='width:".$s["width"]."px;height:".$s["height"]."px;'>";
						$slot1 = new Slots();
						
						$slot_data = $database->select( "slot_data", ["val01", "val02", "val03", "val04", "val05", "val06", "val07", "val08", "val09", "val10"], ["AND" => ["id_account" => $account, "slot" => $s["num"], "status" => 0], "ORDER" => "lordem ASC"] );
						$data = array();
						
						if( count($slot_data) ) {
							foreach($slot_data as $row) {
								$row_tmp = array();
								
								foreach($row as $key => $value) {
									$row_tmp[$key] = $value;
								}
								
								$data[] = $row_tmp;
							}
						}
						
						$slot1->data = $data;
						
						$slot1->connection_type = $connectionType[0];
						$slot1->sql_str = $s["query"];
						
						$slot1->field_1 = $s["field1"];
						$slot1->field_2 = $s["field2"];
						$slot1->field_3 = $s["field3"];
						$slot1->field_4 = $s["field4"];
						$slot1->field_5 = 0;
						$slot1->field_6 = 0;
						$slot1->field_7 = 0;
						$slot1->field_8 = 0;
						$slot1->field_9 = 0;
						$slot1->field_10 = 0;
						
						$slot1->label_1 = $s["label1"];
						$slot1->label_2 = $s["label2"];
						$slot1->label_3 = $s["label3"];
						$slot1->label_4 = $s["label4"];
						
						$slot1->format_1 = $s["format1"];
						$slot1->format_2 = $s["format2"];
						$slot1->format_3 = $s["format3"];
						$slot1->format_4 = $s["format4"];
						$slot1->slot_number = $s["num"];
						$slot1->type = $s["type"];
						$slot1->model = $s["model"];
						$slot1->titulo = $s["title"];
						$slot1->width = $s["width"];
						$slot1->height = $s["height"];
						$slot1->link = $s["link"];
						echo $slot1->getoutput();
						echo "<style>".$s["style"]."</style>";
						echo "</div>";
					}
				?>
			</div>
			<script>		
				jQuery(function() {
					var wall = new freewall('#container');
					wall.reset({
						<?php if( $edit == 't' ) echo 'draggable: true,'; ?>
						selector: '.item',
						gutterX: 5,
						gutterY: 5,
						animate: false
					});
					wall.fitWidth();
					jQuery(window).trigger('resize');
				});
				
				
				jQuery(function() {
					setTimeout(startRefresh,30000);
				});

				function startRefresh() {
					jQuery.get('index.php?a=3&p=1', function(data) {
						jQuery('body').html(data);    
					});
				}
					
					
			</script>
		</body>
<?php
		}
		else {
			header("Location: login.php?a=" . $_GET['a']);
			exit;
		}
?>		