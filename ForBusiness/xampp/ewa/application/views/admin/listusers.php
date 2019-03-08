<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>


<div class="row-fluid">
	<table id="TabEncomendas" class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>Nome</th>
				<th>Email</th>
				<th>ID</th>
				<th></th>
			</tr>
		</thead>   
		<tbody>
		</tbody>
	</table>
</div>
<form method="post" id="theForm" action="editusers">
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
	
	
	var obj = <?php echo json_encode($users->result());?>;
		table.rows().remove().draw();
		
		$.each(obj, function(index, value) {
			var dados = new Array();
			dados.push("<div class='am-checkbox'><input id='check"+value["id"]+"' stamp='"+value["id"]+"'  type='checkbox'><label for='check"+value["id"]+"'></label></div>");
			dados.push("<a onclick='edit_item("+value["id"]+")'>"+value["first_name"]+"</a>");
			dados.push("<a onclick='edit_item("+value["id"]+")'>"+value["email"]+"</a>");
			dados.push(value["id"].substr(0, 10));
			dados.push("<td class='text-center'><a onclick='edit_item("+value["id"]+")' class='btn btn-default'><span class='glyphicon glyphicon-search'></span></a></td>");
			
				
			table.row.add(dados).draw();
		});
		table.columns.adjust();
		
		jQuery("#TabContratos thead tr th").css( "width", "auto");							
				

});
		
		
function edit_item(id){
	$('#theFormid').val(id);
	$('#theForm').submit();
}	
		
$("#delete").click(function(event){
    var values = new Array();
	$.each($("input:checkbox:checked"), function() {
	  values.push($(this).attr('stamp'));
	});
	if(values.length <= 0){
		alert("Select User!");
	}else{
		 if (confirm("Are you sure?")) {
			$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>admin/ajax/delete_user",
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


