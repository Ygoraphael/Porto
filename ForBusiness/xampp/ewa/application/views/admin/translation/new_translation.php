<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<div class="row">
	<?php 
	if($id_post != ""){ ;?>
		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
		</ul>
		<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row">
						<div class="panel panel-default">
							
							<div class="col-md-6">
							  <div class="panel panel-default">
								<div class="panel-body">
										<div class="form-group">
										<label class="col-sm-3 control-label">Key</label>
										<div class="col-sm-9">
											<input id="key" type="text" class="form-control" value="<?php echo $testar['keyvalue'];  ?>" >
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Value</label>
										<div class="col-sm-9">
											<input id="value" type="text" class="form-control" value="<?php echo $testar['textvalue']; ?>" >
										</div>
									</div>
								</div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
										<label class="col-sm-3 control-label">Language</label>
										<div class="col-sm-9">
										<select id="language" class="form-control">
											<?php 
												if($testar['lang'] == "" ) {
											?>
												<option value="0" selected>-Select language-</option>
											<?php }else{
												?>
												<option value="0" selected>-Select language-</option>
												<?php
												}
												foreach ($comboboxlanguages as $row) {
													if($row->language == trim($testar['lang']) ){
														?>
													<option value="<?php echo $row["language"]; ?>" selected><?php echo $row["language"]; ?></option>
												<?php
													}
													else { ?>
														<option value="<?php echo $row["language"]; ?>"><?php echo $row["language"]; ?></option>
												<?php
													} 
												}?>
											</select>
									</div>
							  </div>
							</div>
						 
						</div>
					</div>
				</div>
			</div>
		</form>
	<?php
	}else
	{
	?>
	<ul class="nav nav-tabs">
	   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
	</ul>
	<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<div class="row">
					<div class="panel panel-default">
						<div class="col-md-6">
						  <div class="panel panel-default">
							<div class="panel-body">
								<div class="form-group">
									<label class="col-sm-3 control-label">Key</label>
									<div class="col-sm-9">
										<input id="key" type="text" class="form-control" value="" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Value</label>
									<div class="col-sm-9">
										<input id="value" type="text" class="form-control" value="" >
									</div>
								</div>
							</div>
						  </div>
						</div>
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-body">
									<label class="col-sm-3 control-label">Language</label>
									<div class="col-sm-9">
										<select id="language" class="form-control">
										
											<option value="0" selected>-Select language-</option>
										<?php
											foreach ($comboboxlanguages as $row) {
										?>
											<option value="<?php echo $row["language"]; ?>"><?php echo $row["language"]; ?></option>
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
	</form>
	<?php		
	}	
	//Var Stamp to update_menuitem 
	$u_trans = $testar['u_translatestamp'];
	?>
</div>

<form method="post" id="theForm" action="edit_translations">
<input id="theFormid" type="hidden" name="id" value="<?php echo $u_trans; ?>">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
function criar_menuitem(){
	var key =  $('#key').val();
	var value =  $('#value').val();
	var language =  $('#language').val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_translation"); ?>',
		async: false,
		data:{	'key':key,
				'value':value,
				'language':language		
					},
		success:function(data){
			edit_item(data,1,"Sucesso! ","Criado com successo");
			
		},
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou a inserir");
			//alert(JSON.stringify(data));
		} 
	});
}

function update_menuitem(){
	var id ='<?php if (isset($testar['keyvalue'])) {echo $testar['keyvalue'];}else{ echo 0;}?>';
	var u_translatestamp ='<?php echo $testar['u_translatestamp'];?>';
	var key =  $('#key').val();
	var value =  $('#value').val();
	var language =  $('#language').val();
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_translation"); ?>',
		async: false,
		data:{	
				'u_translatestamp':u_translatestamp,
				'id':id,
				'key':key,
				'value':value,
				'language':language		
					},
		success:function(data){
			
			edit_item(data,1,"Sucesso! ","Gravado com successo");
			//alert(JSON.stringify(u_translatestamp));
			
		},
			
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou ao Gravar!");
			
		} 
	});
}
function edit_item(id,formerror,text1,text2){
	$('#theFormid').val();
	$('#text1').val(text1);
	$('#text2').val(text2);
	$('#theFormerror').val(formerror);
	$('#theForm').submit()
	
}

$("#delete").click(function(event){
  	var values = new Array();
	var id =<?php if (isset($testar['keyvalue'])) {echo $testar['keyvalue'];}else{ echo 0;}?>;
	values.push(id);
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
				window.history.back();
			}
		});
	}
});

</script>
