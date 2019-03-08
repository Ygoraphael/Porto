<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>


<div class="row-fluid">
	<table id="TabEncomendas" class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>STATUS</th>
				<th>MENU</th>
				<th>type</th>
				<th>ID</th>
				<th></th>
			</tr>
		</thead>   
		<tbody>
		</tbody>
	</table>
</div>

<form method="post" id="theForm" action="menusitemnew">
<input id="theFormid" type="hidden" name="id" value="1">
</form>

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
var table;
var position = "";
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
	
	$( ".dataTables_length" ).addClass( "col-md-6" );
	$( ".dataTables_filter" ).addClass( "col-md-6" );
	var obj = <?php echo json_encode($menus->result());?>;
		table.rows().remove().draw();
		
		$.each(obj, function(index, value) {
			var dados = new Array();
			add_row(value["id"],value["text"],value["type"])
			position ="";
			menu_child(value["id"],"");			
		
		});
		table.columns.adjust();
							
				
	
})


function menu_child(id,num_child){
	//position ="";
	
	var obj2 = [];
	
	var id_tmp = id;
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/menu_child"); ?>',
		async: false,
		data:{'id':id},
		success:function(data){
				
			var obj2 = JSON.parse(data);
			if(obj2.length == 0){
				num_child = num_child.slice(0, -2);
			}else{
				num_child=num_child+"x";
			$.each(obj2, function(index, value) {
				
				var text = num_child.replace(/x/g, "|-");

				add_row(value["id"],text+" "+value["text"],value["type"])
				
				menu_child(value["id"],num_child);
				
				
				
			});
			
			}
		}
	});	
}

function add_row(id,text,type){
	var dados = new Array();
	dados.push("<div class='am-checkbox'><input stamp='"+id+"'  id='check"+id+"' type='checkbox'><label for='check"+id+"'></label></div>");
	dados.push("<div class='am-checkbox publish'><input id='pub"+id+"' type='checkbox'><label for='pub"+id+"'></label></div>");
	dados.push('<a onclick=edit_item('+id+')>'+text+'</a>');
	dados.push(type);
	dados.push(id.substr(0, 10));
	dados.push("<td class='text-center'><a onclick='edit_item("+id+")' class='btn btn-default'><span class='glyphicon glyphicon-search'></span></a></td>");
	table.row.add(dados).draw();
}


function edit_item(id){
	$('#theFormid').val(id);
	$('#theForm').submit()
}	

$("#delete").click(function(event){
    var values = new Array();
	$.each($("input:checkbox:checked"), function() {
	  values.push($(this).attr('stamp'));
	});
	if(values.length <= 0){
		alert("Select Menu!");
	}else{
		 if (confirm("Are you sure?")) {
			$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>admin/ajax/delete_menuitem",
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

