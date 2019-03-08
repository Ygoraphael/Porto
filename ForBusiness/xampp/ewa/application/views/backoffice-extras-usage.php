<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
		<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<form action="#" class="form-horizontal group-border-dashed clearfix" >
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Initial Date", $_SESSION['lang_u']); ?></label>
				<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
					<input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
				</div>
				<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Resource", $_SESSION['lang_u']); ?></label>
				<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
					<select class="form-control" id="res" name="">
						<option value=""></option>
						<?php foreach($extras as $extra) { ?>
						<option value="<?php echo $extra["ref"]; ?>"><?php echo $extra["design"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Final Date", $_SESSION['lang_u']); ?></label>
				<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
					<input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
				</div>
				<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></label>
				<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
					<select class="form-control" id="prod" name="">
						<option value=""></option>
						<?php foreach($products as $product) { ?>
						<option value="<?php echo $product["bostamp"]; ?>"><?php echo $product["u_name"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary col-lg-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i><?php echo $this->translation->Translation_key("Mostrar", $_SESSION['lang_u']); ?> </button>
			</div>
		</form>
		<table id="tab-resources" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Start Date", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("End Date", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Resource ID", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Resource Name", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Resource Used", $_SESSION['lang_u']); ?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<script>
	var t;
	
	jQuery(document).ready(function() {
		t = $('#tab-resources').DataTable();
		atualiza_tabela();
	})

	function atualiza_tabela()
	{
		$(".loading-overlay").show();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/get_resources_usage",
			data: { 
				"date_i" : jQuery("#date_i").val().replace(/\-/g,''),
				"date_f" : jQuery("#date_f").val().replace(/\-/g,''),
				"res" : jQuery("#res").val(),
				"prod" : jQuery("#prod").val()
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				t.clear().draw();
				
				$.each(data, function(index, value) {
					var dados = new Array();
					
					dados.push(value["Product"]);
					dados.push(value["Start_Date"].toString().substring(0, 10));
					dados.push(value["End_Date"].toString().substring(0, 10));
					dados.push(value["Ref"]);
					dados.push(value["Design"]);
					dados.push(parseFloat(value["Res_Used"]).toFixed(2));
						
					t.row.add(dados).draw();
				});
				
				$(".loading-overlay").hide();
			}
		});
	}
</script>