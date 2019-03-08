<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<div class="row">

	<?php if($id_post != 0){ ?>
		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
		</ul>
		<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row">
						<div class="panel panel-default">
							<div class="panel-heading">
							  <div class="form-group">
								 <label class="col-sm-1 control-label">Titulo</label>
								 <div class="col-sm-11">
									<input id="title" type="text" class="form-control" value="<?php echo $plugin->title;?>">
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">URL</label>
										<div class="col-sm-9">
											<input id="url" type="text" class="form-control" value="<?php echo $plugin->url;?>">
										</div>
									</div>
								</div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Position</label>
											<div class="col-sm-9">
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
							<div class="panel-heading">
							  <div class="form-group">
								 <label class="col-sm-1 control-label">Titulo</label>
								 <div class="col-sm-11">
									<input id="title" type="text" class="form-control" value="">
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">URL</label>
										<div class="col-sm-9">
											<input id="url" type="text" class="form-control" value="">
										</div>
									</div>
								</div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Position</label>
											<div class="col-sm-9">
												<select id="position" class="form-control">
												<?php 
													foreach ($comboboxposition->result() as $row) {
												?>
													<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
												<?php
													}?>
												</select>
											</div>
										</div>
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

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>


function criar_menuitem(){
	var title =  $('#title').val();
	var url =  $('#url').val();
	var position =  $('#position').val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_plugin"); ?>',
		async: false,
		data:{	'title':title,			
				'url':url,
				'position':position,
				
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
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_plugin"); ?>',
		async: false,
		data:{	
				'id':id,			
				'title':title,			
				'url':url,
				'position':position,				
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


</script>

