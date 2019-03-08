<?php	

	$results = mysql__select("
		SELECT 
			id, 
			data, 
			contador, 
			activo, 
			username, 
			cliente, 
			tarefa, 
			id_projecto projecto 
		FROM tmp_mov 
		WHERE username = '".$_SESSION['user']['username']."' 
		ORDER BY id desc");
	
	//WHERE username = '".$_SESSION['user']['username']."' 
	
	if($results) {
		foreach ( $results as $tarefa ) {
		
			$sql_string = "select nome from cl where estab = 0 and no = " . $tarefa["cliente"];
			$result_phc = mssql__select($sql_string);
			$cliente = $result_phc[0]["nome"];

			$sql_string = "select campo from dytable where dytablestamp = '" . $tarefa["tarefa"] . "'";
			$result_phc = mssql__select($sql_string);
			$tarefa_nome = $result_phc[0]["campo"];
			
			$sql_string = "select telefone from cl where estab = 0 and no = " . $tarefa["cliente"];
			$result_phc = mssql__select($sql_string);
			$telefone = $result_phc[0]["telefone"];
			
			$sql_string = "select tlmvl from cl where estab = 0 and no = " . $tarefa["cliente"];
			$result_phc = mssql__select($sql_string);
			$tlmvl = $result_phc[0]["tlmvl"];
			
			$sql_string = "select email from cl where estab = 0 and no = " . $tarefa["cliente"];
			$result_phc = mssql__select($sql_string);
			$email = $result_phc[0]["email"];
			
			$sql_string = "select sum(esaldo) esaldo from cl where no = " . $tarefa["cliente"];
			$result_phc = mssql__select($sql_string);
			$esaldo = $result_phc[0]["esaldo"];
			
			$contratoLink="";
			
			$projetoLink = "";
			if(strlen(trim($tarefa["projecto"])) != 0) {
				$sql_string = "select nmfref from fref where fref = '".$tarefa["projecto"]."'";
				$result_phc = mssql__select($sql_string);			
				$projeto = $result_phc[0]["nmfref"];
				
				$sql_string = "select frefstamp from fref where fref = '".$tarefa["projecto"]."'";
				$result_phc = mssql__select($sql_string);			
				$projetoLink = "href='projeto.php?frefstamp=".$result_phc[0]["frefstamp"]."'";
			}
			
			$porreg = "€ " . round($esaldo, 2);
		
			$tmp_contador = intval($tarefa["contador"]);
			$hours = $tmp_contador / 3600;
			$tmp_contador = $tmp_contador % 3600;
			$minutes = $tmp_contador / 60;
			$tmp_contador = $tmp_contador % 60;
			$seconds = $tmp_contador;
		?>
			<div id='inter<?php $tarefa["id"]?>' class='span12 widget yellow' style="margin-left:0">
				<div class='span6' style="margin-left:0">
					<div class="clear act_tempo<?php echo $tarefa["id"]; ?>" style='color:white; display:inline-block; font-size:20px;' id='act_tempo'>
						<?php
							if ($tarefa["activo"] != 1) {
								echo sprintf('%02u:%02u:%02u',intval($hours), intval($minutes), $seconds);
							}
						?>
					</div>
					<br><br>
					<?php
						echo "<strong>".$cliente."</strong><br>";
						echo "<b>Tarefa</b>: ".$tarefa_nome."<br>";
						$sql_string = "SELECT *, (select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, (select dbo.ProxDataRenovacaoContrato(csup.no)) data_final, csupstamp FROM csup (nolock) WHERE no = " . $tarefa["cliente"];
						$result_phc = mssql__select($sql_string);
						
						if( sizeof($result_phc) > 0) {
							$contrato_array = $result_phc[0];
							echo "<div><b>Contrato:</b> <b>Inicio:</b> ".substr($contrato_array["data_inicial"], 0, 10)." <b style='margin-left:10px;'>Fim:</b> ".substr($contrato_array["data_final"], 0, 10)." <b style='margin-left:10px;'>H Restantes:</b> ".$contrato_array["u_horasres"]." <b style='margin-left:10px;'>H Contrato:</b> ".$contrato_array["u_horasc"]." </div>";
									
							$contratoLink = "href='contrato.php?csupstamp=".$contrato_array["csupstamp"]."'";
						}
						else {
							echo "<div><b>Contrato:</b> Sem Contrato</div>";
						}
						
						if( $tarefa["projecto"] != "" )
						{
							echo "<div><b>Projecto:</b> ".$tarefa["projecto"]." - " . $projeto . "</div>";
						}
						else {
								echo "<div><b>Projecto:</b></div>";
						}
						
						echo "<div><b>Telefone:</b> ".$telefone."</div>";
						echo "<div><b>Telemóvel:</b> ".$tlmvl."</div>";
						echo "<div><b>Email:</b> ".$email."</div>";
						echo "<div><b>Por Regularizar:</b> ".$porreg."</div>";
						?>
					</div>
					<div class='span6' style="margin-left:0">
					<?php
						if ($tarefa["activo"] == 1) {
					?>
						<a class="quick-button span2" id="inter<?php echo $tarefa["id"]; ?>" onclick="inter_pause(<?php echo $tarefa["id"]; ?>);" style="margin-left:0; margin-right:5px">
							<i class="glyphicons-icon pause"></i>
							<p>Pausar</p>
						</a>
					<?php
						}
						else {
					?>
						<a class="quick-button span2" id="inter<?php echo $tarefa["id"]; ?>" onclick="inter_play(<?php echo $tarefa["id"]; ?>);" style="margin-left:0; margin-right:5px">
							<i class="glyphicons-icon play"></i>
							<p>Continuar</p>
						</a>
					<?php
						}
					?>
						<a class="quick-button span2" href="terminar_intervencao.php?id=<?php echo $tarefa["id"]; ?>" style="margin-left:0; margin-right:5px">
							<i class="glyphicons-icon stop"></i>
							<p>Terminar</p>
						</a>
						<a class="quick-button span2" onclick="inter_remove(<?php echo $tarefa["id"]; ?>)" style="margin-left:0; margin-right:5px">
							<i class="glyphicons-icon remove_2"></i>
							<p>Apagar</p>
						</a>
						<a class="quick-button span2" href="cliente.php?id=<?php echo $tarefa["cliente"]; ?>" style="margin-left:0; margin-right:5px">
							<i class="glyphicons-icon group"></i>
							<p>Cliente</p>
						</a>
						<a class="quick-button span2" style="margin-left:0; margin-right:5px" <?php echo $contratoLink; ?>>
							<i class="glyphicons-icon more_windows"></i>
							<p>Contrato</p>
						</a>
						<a class="quick-button span2" style="margin-left:0; margin-right:5px" <?php echo $projetoLink; ?>>
							<i class="glyphicons-icon check"></i>
							<p>Projeto</p>
						</a>
					</div>
					<?php
				?>
			</div>
			<?php
		}
	
		$infos = mysql__select("
			SELECT id, contador, data 
			FROM tmp_mov 
			WHERE username = '".$_SESSION['user']['username']."'
			ORDER BY id desc");

		if($infos) {
			foreach ( $infos as $info ) {
				echo "<input type='hidden' class='cur_contador".$info["id"]."' value='".$info["contador"]."' />";
				echo "<input type='hidden' class='cur_data".$info["id"]."' value='".$info["data"]."' />";
				echo "<input type='hidden' class='cur_timer".$info["id"]."' value='' />";
			}
		}
	}
	?>
	<script>
		function pad(n) { return ("0" + n).slice(-2); }
		var current_timestamp;
		
		function inter_remove(id) {
			bootbox.confirm("Deseja mesmo apagar esta intervenção?", function(result) {
				if(result){
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "inter_remove(" + id + ");"},
						success: function(data) {
							if(data) {
								clearInterval(jQuery(".cur_timer" + id).val());
								
								jQuery("#inter" + id).parent().parent().fadeOut(1000, function() {
									jQuery(".cur_data" + id).remove();
									jQuery(".cur_contador" + id).remove();
									jQuery("#inter" + id).parent().parent().remove();
								});
							}
						}
					});
				}
			});
		}
		
		function inter_play(id) {
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "set_inter_play(" + id + ");"},
				success: function(data) {
					if(data.indexOf(';') > -1) {
						jQuery("#inter" + id).prop('onclick',null).off('click');
						jQuery("#inter" + id).click(function() {
							inter_pause(id);
						});
						var res = data.split(";");
						jQuery(".cur_data" + id).val(res[0]);
						jQuery(".cur_contador" + id).val(res[1]);
						jQuery("#inter" + id).children().eq(0).removeClass("play");
						jQuery("#inter" + id).children().eq(0).addClass("pause");
						jQuery("#inter" + id).children().eq(1).html("Pausar");
						myTimer(0, id, 1);
					}
				}
			});
		}
		
		function inter_pause(id) {
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "set_inter_pause(" + id + ");"},
				success: function(data) {
					if(data) {
						clearInterval(jQuery(".cur_timer" + id).val());
						jQuery("#inter" + id).prop('onclick',null).off('click');
						jQuery("#inter" + id).click(function() {
							inter_play(id);
						});
						jQuery("#inter" + id).children().eq(0).removeClass("pause");
						jQuery("#inter" + id).children().eq(0).addClass("play");
						jQuery("#inter" + id).children().eq(1).html("Continuar");
					}
				}
			});
		}
		
		function myTimer(blabla, id, ajax) {
			if(ajax) {
				$.ajax({
					url: "get_timestamp.php",
					success: function(data) {
						current_timestamp = data;
						var blabla = current_timestamp - Math.round((new Date()).getTime() / 1000);
						myTimer(blabla, id, 0);
						timerId = setInterval( 
							function() {
								myTimer(blabla, id, 0);
							}, 1000)
						jQuery(".cur_timer" + id).val(timerId);
					}
				})
			}
			else {
				var ts = Math.round((new Date()).getTime() / 1000) + parseInt(blabla);	
				
				var current_contador = parseInt($(".cur_contador" + id).val()) + ts - parseInt($(".cur_data" + id).val());
				var hours = current_contador / 3600;
				current_contador = current_contador % 3600;
				var minutes = current_contador / 60;
				current_contador = current_contador % 60;
				var seconds = current_contador
				
				$(".act_tempo" + id).html(pad(Math.floor(hours)) + ':' + pad(Math.floor(minutes)) + ':' + pad(Math.floor(seconds)));
			}
		}
	<?php
	$infos = mysql__select("
		SELECT id, contador, data 
		FROM tmp_mov 
		WHERE username = '".$_SESSION['user']['username']."' AND activo = 1
		ORDER BY id desc");

	if($infos) {
		foreach ( $infos as $info ) {
		?>
		myTimer(0, <?php echo $info["id"]; ?>, 1);
	<?php
		}
	}
	?>
	</script>
