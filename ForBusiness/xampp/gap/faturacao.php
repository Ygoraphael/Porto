<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>

<body>
		<!-- start: Header -->
	<?php include("nav_bar.php"); ?>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
			<div class="row-fluid">
				<!-- start: Main Menu -->
				<?php include("menu.php"); ?>
				<!-- end: Main Menu -->
				
				<noscript>
					<div class="alert alert-block span10">
						<h4 class="alert-heading">Warning!</h4>
						<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
					</div>
				</noscript>
				
				<!-- start: Content -->
				<div id="content" class="span10">
					<?php 
						$current_page = "Faturação";
						include("breadcrumbs.php");
						
						$campos = get_campos_tabela('FT');
						
						if(sizeof($campos)<=0) {
							return;
						}
					?>
						
					<div class="row-fluid">
						<div class="span12">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<br><br>
							<form class="form-horizontal">
								<div class="control-group">
									<div class="controls">
										<select onchange="" id="log_op" class="span1 form-control">
											<option></option>
											<option value="and">E</option>
											<option value="or">OU</option>
											<option value="and(">E (</option>
											<option value="or(">OU (</option>
											<option value=")and(">) E (</option>
											<option value=")or(">) OU (</option>
											<option value="(">(</option>
											<option value=")">)</option>
										</select>
										<select onchange="" id="val1" class="span3 form-control">
											<option></option>
											<?php
												foreach($campos as $campo) {
													echo "<option value='" . $campo["nomecampo"] . "'>" . $campo["titulo"] . "</option>";
												}
											?>
										</select>
										<select onchange="" id="comp_op" class="span2 form-control">
											<option value="=">IGUAL</option>
											<option value=">=">MAIOR OU IGUAL</option>
											<option value="<=">MENOR OU IGUAL</option>
											<option value="<>">DIFERENTE</option>
											<option value="%x%">CONTÉM</option>
											<option value="n%x%">NÃO CONTÉM</option>
											<option value="x%">COMEÇA POR</option>
											<option value="%x">TERMINA EM</option>
										</select>
										<input type="text" class="span3" value='' id="val2">
										<a class="btn btn-success" onclick="addFilter();"><i class="halflings-icon white plus-sign"></i></a>
										<a class="btn btn-primary" onclick="runQuery();"><i class="white halflings-icon search"></i> Pesquisar</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<table id="TabFiltro" class="table table-striped bootstrap-datatable">
								<thead>
									<tr>
										<th class="span10"></th>
										<th class="hidden"></th>
										<th class="hidden"></th>
										<th class="hidden"></th>
										<th class="hidden"></th>
										<th class="span2"></th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="span6">
							<textarea id="queryTab" class="span12" style="height:20vh; background:white;" readonly=""></textarea>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<table id="TabDoc" class="table table-striped bootstrap-datatable">
								<thead>
									<tr>
										<th>Documento</th>
										<th>Nº</th>
										<th>Nº Cliente</th>
										<th>Cliente</th>
										<th>Data</th>
										<th>Base Inc.</th>
										<th>IVA</th>
										<th>Total</th>
										<th></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
				<!-- end: Content -->
		</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	<script>
		function runQuery() {
			var tmp_qr = getFilter();
			if(tmp_qr.length <= 0)
				return;
			
			ActivateLoading();
			
			var table = $('#TabDoc').DataTable({
				dom: 'lBfrtip',
				buttons: [
					{
						extend:    'copy',
						text:      '<i class="fa fa-copy"></i> Copiar',
						titleAttr: 'Copiar'
					},
					{
						extend:    'csv',
						text:      '<i class="fa fa-file-text-o"></i> CSV',
						titleAttr: 'CSV'
					},
					{
						extend:    'excel',
						text:      '<i class="fa fa-file-excel-o"></i> Excel',
						titleAttr: 'Excel'
					},
					{
						extend:    'pdf',
						text:      '<i class="fa fa-file-pdf-o"></i> PDF',
						titleAttr: 'PDF'
					},
					{
						extend:    'print',
						text: '<i class="fa fa-print"></i> Imprimir',
						titleAttr: 'Imprimir'
					}
				],
				oLanguage: {
					sSearch: "Procurar:",
					oPaginate: {
						sFirst:		"Primeiro",
						sLast:		"Último",
						sNext:		"Seguinte",
						sPrevious:	"Anterior"
					},
					"sInfo": "A mostrar _START_ até _END_ registos de um total de _TOTAL_ registos",
					"sLengthMenu":     "Mostrar _MENU_ registos"
				},
				"bDestroy": true,
				"iDisplayLength": 100,
				sPaginationType : "full_numbers"
			});
			
			$('#TabDoc').DataTable().clear();
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "get_docs_cabecalho('ft','nmdoc, fno, no, nome, fdata, ettiliq, ettiva, etotal, ftstamp', ' " + window.btoa(tmp_qr) + "');"},
				success: function(data) 
				{
					
					try {
						var obj = JSON.parse(data);
						
						$.each(obj, function(index, value) {
							var dados = new Array();
							dados.push(value["nmdoc"]);
							dados.push(value["fno"]);
							dados.push(value["no"]);
							dados.push(value["nome"]);
							dados.push(value["fdata"]);
							dados.push(parseFloat(value["ettiliq"]).toFixed(2));
							dados.push(parseFloat(value["ettiva"]).toFixed(2));
							dados.push(parseFloat(value["etotal"]).toFixed(2));
							dados.push('<a class="btn btn-success" href="clientedoc.php?docstamp=' + value["ftstamp"] + '"><i class="halflings-icon white zoom-in"></i></a>');
							
							table.row.add(dados).draw();
						});
						
						jQuery("#TabDoc thead tr th").css( "width", "auto");
						DeactivateLoading();
					}
					catch(err) {
						DeactivateLoading();
					}
				}
			});
			
		}
		
		function removeTR(obj) {
			obj.parentElement.parentElement.remove();
			$('#log_op').val("");
			$('#val1').val("");
			$('#comp_op').val("");
			$('#val2').val("");
			
			var tmp_qr = getFilter();
			
			if(tmp_qr.length > 0)
				$('#queryTab').html("select * from ft where \n" + tmp_qr);
			else
				$('#queryTab').html("");
		}
		
		function addFilter() {
			var linha = "<td>" + $('#log_op').find(":selected").text() + " " + $('#val1').find(":selected").text() + " " + $('#comp_op').find(":selected").text() + " '" + $('#val2').val() + "'</td>";
			linha += "<td class='hidden'>" + jQuery("#log_op").val() + "</td>";
			linha += "<td class='hidden'>" + jQuery("#val1").val() + "</td>";
			linha += "<td class='hidden'>" + jQuery("#comp_op").val() + "</td>";
			linha += "<td class='hidden'>" + jQuery("#val2").val() + "</td>";
			$('#TabFiltro tr:last').after('<tr>' + linha + '<td><a class="btn btn-success" onclick="removeTR(this)"><i class="halflings-icon white minus-sign"></i></a></td></tr>');
			
			$('#log_op').val("");
			$('#val1').val("");
			$('#comp_op').val("");
			$('#val2').val("");
			
			var tmp_qr = getFilter();
			
			if(tmp_qr.length > 0)
				$('#queryTab').html("select * from ft where \n" + tmp_qr);
			else
				$('#queryTab').html("");
		}
		
		function getFilter() {
			var tmp_str = "";
			
			$('#TabFiltro tr').not(':first').each(function() {
				if($(this).children().eq(3).html() == "=") {
					tmp_log = "= '" + $(this).children().eq(4).html() + "'";
				}
				else if($(this).children().eq(3).html() == "&gt;=") {
					tmp_log = ">= '" + $(this).children().eq(4).html() + "'";
				}
				else if($(this).children().eq(3).html() == "&lt;=") {
					tmp_log = ">= '" + $(this).children().eq(4).html() + "'";
				}
				else if($(this).children().eq(3).html() == "&lt;&gt;") {
					tmp_log = "<> '" + $(this).children().eq(4).html() + "'";
				}
				else if($(this).children().eq(3).html() == "%x%") {
					tmp_log = "LIKE '%" + $(this).children().eq(4).html() + "%'";
				}
				else if($(this).children().eq(3).html() == "n%x%") {
					tmp_log = "NOT LIKE '%" + $(this).children().eq(4).html() + "%'";
				}
				else if($(this).children().eq(3).html() == "x%") {
					tmp_log = "LIKE '" + $(this).children().eq(4).html() + "%'";
				}
				else if($(this).children().eq(3).html() == "%x") {
					tmp_log = "LIKE '%" + $(this).children().eq(4).html() + "'";
				}
				
				tmp_str += $(this).children().eq(1).html() + "  " + $(this).children().eq(2).html() + " " + tmp_log + "\n"
			});
			
			return tmp_str;
		}
	</script>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
