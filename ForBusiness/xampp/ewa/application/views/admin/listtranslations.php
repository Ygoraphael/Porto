<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="col-sm-12 col-md-12 col-xs-12">
	<div class="row setup-content">
		<div class="col-sm-12 col-md-12 col-xs-12">
			<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix" novalidate="true">
				<div class="form-group col-sm-6">
					<label class="col-sm-2 control-label">Language</label>
					<div class="col-sm-10">
						<select class="form-control" id="lang" name="">
							<option value="">- Select Language -</option>
							<?php foreach($comboboxlanguages as $la) { ?>
							<option value="<?php echo $la["language"]; ?>" <?php echo (trim($la["language"]) == "English") ? "selected" : ""; ?>><?php echo $la["language"]; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group col-sm-6">
				   <div class="col-sm-3"><button class="btn btn-primary form-control" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i>SHOW</button></div>
				</div>
			</form>
		</div>
	</div>
	<div class="row-fluid">
		<table id="tab-p" class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>KEY</th>
					<th>VALUE</th>
					<th>LANGUAGE</th>
					<th>ID</th>
					<th></th>
				</tr>
			</thead>   
			<tbody>
			</tbody>
		</table>
	</div>
	<form method="post" id="theForm" action="edit_translations">
		<input id="theFormid" type="hidden" name="id" value="1">
	</form>
</div>
 

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
	var t;
	
	jQuery(document).ready(function() {
		t = $('#tab-p').DataTable({
		dom: 'lBfrtip',
		buttons: [	],
		oLanguage: {
			sSearch: "<?php echo "Procurar" ?>:",
			oPaginate: {
				sFirst:		"Primeiro",
				sLast:		"Último",
				sNext:		"Seguinte",
				sPrevious:	"Anterior"
			},
			"sInfo": "A mostrar _START_ até _END_ registos de um total de _TOTAL_ registos",
			"sLengthMenu":     "Mostrar _MENU_ registos"
		},
		"iDisplayLength": 100,
		sPaginationType : "full_numbers"
	});
		atualiza_tabela();
		
	})
	
	function atualiza_tabela(){
		$(".loading-overlay").show();
		var lang = $("#lang").val();
		
		jQuery.ajax({
			type: "POST",
			url: '<?php echo base_url("admin/ajax/translations2"); ?>',
			data: { 
				"lang" : lang	
			},
			success:function(data){
				data = JSON.parse(data);
				t.clear().draw();
				
				$.each(data, function(index, value) {
					var dados = new Array();
					dados.push("<div class='am-checkbox'><input stamp='"+value["keyvalue"]+"' id='check"+value["u_translatestamp"]+"' type='checkbox'><label for='check"+value["keyvalue"]+"'></label></div>");
					dados.push("<a onclick='edit_item(\""+value["u_translatestamp"]+"\")'>"+value["keyvalue"]+"</a>");
					dados.push("<a onclick='edit_item(\""+value["u_translatestamp"]+"\")'>"+value["textvalue"]+"</a>");
					dados.push(value["lang"]);
					dados.push(value["keyvalue"].substr(0, 10));
					dados.push("<a onclick='edit_item(\""+value["u_translatestamp"]+"\")'><span class='glyphicon glyphicon-search'></span></a>");
						
					t.row.add(dados).draw();
				});
				$(".loading-overlay").hide();
			}
		});
	}

	function edit_item(id){
		$('#theFormid').val(""+id+"");
		$('#theForm').submit()
	}	

	$("#delete").click(function(event){
		var values = new Array();
		
		$.each($("input:checkbox:checked"), function() {
			values.push($(this).attr('stamp'));
		});
		
		if(values.length <= 0){
			alert("Select Language!");
		}
		else {
			 if (confirm("Are you sure?")) {
				$(".loading-overlay").show();
					jQuery.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>admin/ajax/delete_translations",
						data: { 
							"id" : values
						},
						success: function(data) 
						{
							$(".loading-overlay").hide();
							location.reload();
						}
					});
			}
		}
	   
	});	
</script>


