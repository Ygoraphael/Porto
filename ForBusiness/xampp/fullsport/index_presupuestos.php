<div class="large-4 columns">
	<div class="panel paneldash" style="background:#D0D0D0;">
		<div class="row">
			<div class="large-12 small-12 columns">
				<h5>Presupuestos</h5>
			</div>
		</div>
<?php
	$query = "
		select top 6
			obrano, nome, dataopen datapedido,
			logi2 preparado, logi3 enviado, 
			logi1 adjudicado, logi4 receb40,
			u_dataprep datapreparacao,
			u_dataenvi dataenvio, datafinal dataadj, u_datapag datarec40,
			isnull((select top 1 proj.obrano from bi orc inner join bi proj on orc.bistamp = proj.oobistamp and orc.ndos = 3 and proj.ndos = 7 and orc.bostamp = bo.bostamp), 0) proj
		from
			bo
		where
			ndos = 3 and
			fechada = 0
		order by
			u_dataprep asc,
			u_dataenvi asc,
			datafinal asc,
			u_datapag asc
	";
	$dados = $SqlServer->GetData($query);
	$linha_tmp = 0;
	
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
			<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
				<div class="row nopadding" style="height:50%;">
					<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
						<?php echo $linha["obrano"] . " - " . $linha["nome"]; ?>
					</div>
				</div>
				<div class="row nopadding" style="height:50%;">
					<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
						<?php echo substr($linha["datapedido"], 0, 10); ?>
					</div>
				</div>
			</div>
			<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
				<?php
					if( $linha["preparado"] == 1 && $linha["enviado"] == 1 && $linha["adjudicado"] == 1 && $linha["receb40"] == 1 && $linha["proj"] == 0) {
						?><a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem;">Projecto</a><?php
					}
					if( $linha["preparado"] == 1 && $linha["enviado"] == 1 && $linha["adjudicado"] == 1 && $linha["receb40"] == 1 && $linha["proj"] != 0) {
						?><a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem;">Fechar</a><?php
					}
					else if ( $linha["preparado"] == 1 && $linha["enviado"] == 0 && $linha["adjudicado"] == 0 && $linha["receb40"] == 0 ) {
						?><a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem;">Enviar</a><?php
					}
					else if ( $linha["preparado"] == 1 && $linha["enviado"] == 1 && $linha["adjudicado"] == 0 && $linha["receb40"] == 0 ) {
						?><a href="#" class="button orange right nomargin button_padding001" style="margin-top:0.6rem;">Adjudicar</a><?php
					}
					else if ( $linha["preparado"] == 1 && $linha["enviado"] == 1 && $linha["adjudicado"] == 1 && $linha["receb40"] == 0 ) {
						?><a href="#" class="button orange right nomargin button_padding001" style="margin-top:0.6rem;">Pagamento</a><?php
					}
				?>
			</div>
		</div>
	<?php
		}
		$linha_tmp++;
	}
?>
	</div>
</div>