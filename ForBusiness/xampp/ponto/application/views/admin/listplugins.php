<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>


<div class="row-fluid">
	<table id="TabEncomendas" class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>Titulo</th>
				<th>Position</th>
				<th>ID</th>
			</tr>
		</thead>   
		<tbody>
		</tbody>
	</table>
</div>
<form method="post" id="theForm" action="editplugin">
<input id="theFormid" type="hidden" name="id" value="1">
</form>
<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
var table;

$(document).ready(function () {
	table = $('#TabEncomendas').DataTable({
		dom: 'lBfrtip',
		buttons: [
		
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
		"iDisplayLength": 100,
		sPaginationType : "full_numbers"
	});
	
	
	var obj = <?php echo json_encode($plugins->result());?>;
		table.rows().remove().draw();
		
		$.each(obj, function(index, value) {
			var dados = new Array();
			dados.push("<div class='am-checkbox'><input stamp='"+value["id"]+"' id='check"+value["id"]+"' type='checkbox'><label for='check"+value["id"]+"'></label></div>");
			dados.push("<a onclick='edit_item("+value["id"]+")'>"+value["title"]+"</a>");
			dados.push(value["position_name"]);
			dados.push(value["id"].substr(0, 10));
			
				
			table.row.add(dados).draw();
		});
		table.columns.adjust();
		
		jQuery("#TabContratos thead tr th").css( "width", "auto");							
				

});
		
		
function edit_item(id){
	$('#theFormid').val(id);
	$('#theForm').submit();
}	
		
		
		
</script>


