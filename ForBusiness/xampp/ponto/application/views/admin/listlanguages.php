<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$CI =& get_instance();
$CI->load->library('translation');

?>
<!DOCTYPE html>


<div class="row-fluid">
	<table id="TabEncomendas" class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th><?php echo $this->translation->Translation_key('country');?> </th>
			</tr>
		</thead>   
		<tbody>
		</tbody>
	</table>
</div>
<form method="post" id="theForm" action="edit_countries">
<input id="theFormid" type="hidden" name="id" value="1">
</form>

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
	
	
	var obj = <?php echo json_encode($countries->result());?>;
	table.rows().remove().draw();
	
	$.each(obj, function(index, value) {
		var dados = new Array();
		dados.push("<div class='am-checkbox'><input stamp='"+value["u_plangstamp"]+"'  id='check"+value["u_plangstamp"]+"' type='checkbox'><label for='check"+value["code"]+"'></label></div>");
		dados.push('<a onclick="edit_item(\''+value["u_plangstamp"]+'\')">'+value["language"]+'</a>');
		//dados.push('<a onclick="edit_item(\''+value["u_plangstamp"]+'\')">'+value["code"]+'</a>');
	
		table.row.add(dados).draw();
	});
	table.columns.adjust();
	
	jQuery("#TabEncomendas thead tr th").css( "width", "auto");							
				
	 var table = $('#TabEncomendas').DataTable();

    $('#TabEncomendas tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        console.log(data);
    });
});
		
		
function edit_item(id){
	$('#theFormid').val(id);
	$('#theForm').submit()
}	
		
		
		
</script>


