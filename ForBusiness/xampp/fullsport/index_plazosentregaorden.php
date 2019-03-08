<div class="large-4 columns">
	<div class="panel paneldash" style="background:#D0D0D0;">
		<div class="row">
			<div class="large-12 small-12 columns">
				<h5>Plazos de entrega orden</h5>
			</div>
		</div>
<?php
	$randhs = incrementalHash();
	$query = "
		select top 6
			bo.obrano, bo.nome, bo.trab1, bo.trab3, nome,  
			bo.u_dataped1 dataconfcliente, bo.u_dataaam dataenvioproducao, 
			bo.u_dataades datalimentregaprod, bo2.u_expedido expedido, bo.dataopen dataexpedicao,
			isnull((select top 1 u_urgencia from bo a inner join bo2 on bostamp = bo2stamp where obrano = bo.trab1 and ndos = 7), 0) semanasentrega
		from
			bo inner join bo2 on bo.bostamp = bo2.bo2stamp
		where
			bo.ndos = 11 and
			bo.fechada = 0
	";
	$dados = $SqlServer->GetData($query);
	$linha_tmp = 0;
	$script = "";
	
	foreach($dados as $linha) {
		if($linha_tmp == 5) {
		?>
			<div class="row">
				<div class="large-12 small-12 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
					<div class="row nopadding" style="height:100%;">
						<div class="large-12 small-12 text-center columns text003" style="background:#F8F8F8; padding-top:15px;">
							Más...
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		else {
	?>
		<div class="row">
			<div class="large-12 small-12 columns text003" style="height:70px; margin-bottom:3px; background:#F8F8F8;">
				<div class="row nopadding" style="height:33%;">
					<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
						<?php echo $linha["obrano"]. " - Proj. " . $linha["trab1"] . " " . $linha["trab3"]; ?>
					</div>
				</div>
				<div class="row nopadding" style="height:23%;">
					<div class="large-6 small-6 columns text004" style="background:#F8F8F8;">
						<?php
								echo substr($linha["dataconfcliente"], 0, 10);
						?>
					</div>
					<div class="large-6 small-6 columns text004 text-right" style="background:#F8F8F8;">
						<?php
							if( $linha["semanasentrega"] != 0 ) {
								$date = strtotime(substr($linha["dataconfcliente"], 0, 10));
								$new_date = strtotime("+" . $linha["semanasentrega"] . " Week", $date); 
								echo date('Y-m-d', $new_date);
							}
							else {
								$date = strtotime(substr($linha["dataconfcliente"], 0, 10));
								$new_date = strtotime(substr($linha["dataconfcliente"], 0, 10));
								echo date('Y-m-d', $new_date);
							}
						?>
					</div>
				</div>
				<div class="row nopadding" style="height:43%;">
					<div class="<?php echo $randhs . $linha_tmp; ?> progress-bar green stripes"><span style="width: 0%"></span></div>
				</div>
			</div>
		</div>
	<?php		
			$diff_dates = $new_date - $date;
			$diff_cur_dates = strtotime("now") - $date;
			
			if ($diff_dates > 0) {
				if ($diff_cur_dates == 0) {					
					$script .= "		
						jQuery(function() {
							$('." . $randhs . $linha_tmp . "').children('span').css('width','0%');
						});
					";
				}
				else if ($diff_cur_dates > $diff_dates) {					
					$script .= "		
						jQuery(function() {
							$('." . $randhs . $linha_tmp . "').children('span').css('width','100%');
						});
					";
				}
				else {
					$script .= "		
						jQuery(function() {
							$('." . $randhs . $linha_tmp . "').children('span').css('width','" . ($diff_cur_dates/$diff_dates*100) . "%');
						});
					";
				}
			}
			else {
				$script .= "		
					jQuery(function() {
						$('." . $randhs . $linha_tmp . "').children('span').css('width','100%');
					});
				";
			}
		}
		$linha_tmp++;
	}
?>
	</div>
</div>
<script><?php echo $script; ?></script>