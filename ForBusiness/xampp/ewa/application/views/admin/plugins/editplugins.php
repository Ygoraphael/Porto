<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<div class="row">

	<?php if($id_post != 0) { ?>
		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
		</ul>
		<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row">
						<div class="panel panel-default">
							<div class="col-md-12">
							  <div class="form-group">
								 <label class="col-sm-1 control-label">Titulo</label>
								 <div class="col-sm-11">
									<input id="title" type="text" class="form-control" value="<?php echo $plugin->title;?>">
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-2 control-label">URL</label>
									<div class="col-sm-10">
										<input id="url" type="text" class="form-control" value="<?php echo $plugin->url;?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-2 control-label">Position</label>
									<div class="col-sm-10">
										<select id="position" class="form-control">
										<?php 
											foreach ($comboboxposition->result() as $row) {
												if($position_id == $row->id ){
													?>
												<option value="<?php echo $row->id; ?>" selected><?php echo $row->name; ?></option>
										<?php
												}else{
										?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
										<?php
												}}?>
										</select>
									</div>
								</div>
						   </div>
						   <div class="col-md-12">
								<div class="form-group">
									<label class="col-sm-1 control-label">Active Pages</label>
									<div class="col-sm-11">
										<table id="page_url_tab" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>URL</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php
													$cur_row = 0;
													foreach ($pluginspage as $row) { ?>
													<tr>
													<td row="<?php echo $cur_row; ?>"><div class="input-group"><span class="input-group-addon"><?php echo base_url(); ?></span><input type="text" value="<?php echo $row["url"]; ?>" class="form-control url_inp" /></div></td>
													<td class="text-center"><a href="#" onclick="delete_page(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
													</tr>
												<?php
													$cur_row++;
													} ?>
											</tbody>
										</table>
										<button type="button" id="url_add" class="btn btn-info btn-lg pull-left">ADD URL</button>
										<small class="col-md-12" style="margin-top:15px">
											<b>Notes:</b><br>
											[abc]     A single character: a, b or c<br>
											[^abc]     Any single character but a, b, or c<br>
											[a-z]     Any single character in the range a-z<br>
											[a-zA-Z]     Any single character in the range a-z or A-Z<br>
											^     Start of line<br>
											$     End of line<br>
											\A     Start of string<br>
											\z     End of string<br>
											.     Any single character<br>
											\s     Any whitespace character<br>
											\S     Any non-whitespace character<br>
											\d     Any digit<br>
											\D     Any non-digit<br>
											\w     Any word character (letter, number, underscore)<br>
											\W     Any non-word character<br>
											\b     Any word boundary character<br>
											(...)     Capture everything enclosed<br>
											(a|b)     a or b<br>
											a?     Zero or one of a<br>
											a*     Zero or more of a<br>
											a+     One or more of a<br>
											a{3}     Exactly 3 of a<br>
											a{3,}     3 or more of a<br>
											a{3,6}     Between 3 and 6 of a
										</small>
									</div>
								</div>
						   </div>
						</div>
					</div>
				</div>
			</div>
		</form>
	<?php
	}else{
	?>
		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
		</ul>
		<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row">
						<div class="panel panel-default">
							<div class="col-md-12">
							  <div class="form-group">
								 <label class="col-sm-1 control-label">Titulo</label>
								 <div class="col-sm-11">
									<input id="title" type="text" class="form-control" >
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-2 control-label">URL</label>
									<div class="col-sm-10">
										<input id="url" type="text" class="form-control" >
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-2 control-label">Position</label>
									<div class="col-sm-10">
										<select id="position" class="form-control">
										<?php foreach ($comboboxposition->result() as $row) { ?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
						   </div>
						   <div class="col-md-12">
								<div class="form-group">
									<label class="col-sm-1 control-label">Active Pages</label>
									<div class="col-sm-11">
										<table id="page_url_tab" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>URL</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<button type="button" id="url_add" class="btn btn-info btn-lg pull-left">ADD URL</button>
										<small class="col-md-12" style="margin-top:15px">
											<b>Notes:</b><br>
											[abc]     A single character: a, b or c<br>
											[^abc]     Any single character but a, b, or c<br>
											[a-z]     Any single character in the range a-z<br>
											[a-zA-Z]     Any single character in the range a-z or A-Z<br>
											^     Start of line<br>
											$     End of line<br>
											\A     Start of string<br>
											\z     End of string<br>
											.     Any single character<br>
											\s     Any whitespace character<br>
											\S     Any non-whitespace character<br>
											\d     Any digit<br>
											\D     Any non-digit<br>
											\w     Any word character (letter, number, underscore)<br>
											\W     Any non-word character<br>
											\b     Any word boundary character<br>
											(...)     Capture everything enclosed<br>
											(a|b)     a or b<br>
											a?     Zero or one of a<br>
											a*     Zero or more of a<br>
											a+     One or more of a<br>
											a{3}     Exactly 3 of a<br>
											a{3,}     3 or more of a<br>
											a{3,6}     Between 3 and 6 of a
										</small>
									</div>
								</div>
						   </div>
						</div>
					</div>
				</div>
			</div>
		</form>
	<?php		
	}?>
</div>



	
<form method="post" id="theForm" action="editplugin">
<input id="theFormid" type="hidden" name="id" value="1">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script><script>

function delete_page(obj) {
	obj.parent().parent().remove();
}

jQuery('#url_add').on( 'click', function () {
	var max_row = 0;
	jQuery( "#page_url_tab tbody tr" ).each(function() {
		var row = parseFloat( jQuery(this).children().eq(0).attr("row") );
		
		if( row > max_row ) {
			max_row = row;
		}
	});
	
	max_row = max_row + 1;
	
	var row = '';
	row += '<tr>';
	row += '<td row="'+max_row+'"><div class="input-group"><span class="input-group-addon"><?php echo base_url(); ?></span><input type="text" class="form-control url_inp" /></div></td>';
	row += '<td class="text-center"><a href="#" onclick="delete_page(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
	row += '</tr>';
	
	jQuery('#page_url_tab tbody').append(row);
});

function criar_menuitem(){
	var title =  $('#title').val();
	var url =  $('#url').val();
	var position =  $('#position').val();
	
	var input = new Array();
	$('.url_inp').each(function(i, obj) {
		input.push( jQuery(this).val() );
	});
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_plugin"); ?>',
		async: false,
		data:{	
			'title':title,			
			'url':url,
			'position':position,
			"input" : JSON.stringify(input)
		},
		success:function(data){
			edit_item(data,1,"Sucesso! ","Página criada com successo");		
		},
		error: function(data) { 
			//edit_item(data,2,"Erro! ","Falhou a inserir");
				alert(JSON.stringify(data));
		} 
	});
}

function update_menuitem(){
	var title =  $('#title').val();
	var url =  $('#url').val();
	var position =  $('#position').val();
	var id =<?php if (isset($plugin->id)) {echo $plugin->id;}else{ echo 0;}?>;
	
	var input = new Array();
	$('.url_inp').each(function(i, obj) {
		input.push( jQuery(this).val() );
	});
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_plugin"); ?>',
		async: false,
		data:{	
			'id':id,			
			'title':title,			
			'url':url,
			'position':position,
			"input" : JSON.stringify(input)
		},
		success:function(data){
			edit_item(data,1,"Sucesso! ","Menu Gravado com successo");
			
		},
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou ao Gravar!");
		} 
	});
}

function edit_item(id,formerror,text1,text2){
	$('#theFormid').val(id);
	$('#text1').val(text1);
	$('#text2').val(text2);
	$('#theFormerror').val(formerror);
	$('#theForm').submit()
}

$("#delete").click(function(event){
  	var values = new Array();
	var id =<?php if (isset($plugin->id)) {echo $plugin->id;}else{ echo 0;}?>;
	values.push(id);
	if (confirm("Are you sure?")) {
		$(".loading-overlay").show();
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>admin/ajax/delete_plugins",
			data: { 
				"id" : values
			},
			success: function(data) 
			{
				$(".loading-overlay").hide();
				window.history.back();
			}
		});
	}
});
</script>

