<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<div class="row">

		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
		</ul>
	<?php if($id_post != 0){ ?>
		<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row">
						<div class="panel panel-default">
							<div class="col-md-11">
								<div class="panel panel-default">
									<?php 
									
									foreach ($fields as $field)
									{
										$value = $field->field;
										echo '<div class="form-group col-sm-6" style="height: 68px;">';
										echo '<label class="col-sm-5 control-label">'.$field->name.'</label>';
										echo '<div class="col-sm-7">';
										if($field->type=="checkbox" ){
											echo '<div class="switch-button switch-button-info">';
											if($user->$value== 0){
												echo '<input class="activeInput" type="checkbox" name="'.$field->field.'" id="'.$field->field.'"><span>';
											}else{
												echo '<input class="activeInput" type="checkbox" name="'.$field->field.'" id="'.$field->field.'" checked><span>';
											}
											echo '<label for="'.$field->field.'"></label></span>';
											echo '</div>';
										}else if($field->type=="combobox" ){
											if($user->$value == 'male'){
												echo '<select class="form-control activeInput" name="'.$field->field.'">
														<option value="0">-select gender-</option>
														<option value="male" selected>male</option>
														<option value="female">female</option>
														</select>';
											}else if($user->$value == 'female'){
												echo '<select class="form-control activeInput" name="'.$field->field.'">
														<option value="0">-select gender-</option>
														<option value="male">male</option>
														<option value="female" selected>female</option>
														</select>';												
											}else{
												echo '<select class="form-control activeInput" name="'.$field->field.'">
														<option value="0" selected>-select gender-</option>
														<option value="male">male</option>
														<option value="female">female</option>
														</select>';
											}
											
										}else if($field->type=="date" ){
											$date = date("Y-m-d", strtotime($user->$value));
											echo '<input id="'.$field->field.'" type="'.$field->type.'" name="'.$field->field.'" class="form-control activeInput" value="'.$date.'">';											
										}else{
											echo '<input id="'.$field->field.'" type="'.$field->type.'" name="'.$field->field.'" class="form-control activeInput" value="'.$user->$value.'">';
										}
										echo '</div></div>';
									} ?>
								</div>
							</div>
					   
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php }else{?>
		<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row">
						<div class="panel panel-default">
							<div class="col-md-11">
								<div class="panel panel-default">
									<?php 
									foreach ($fields as $field)
									{
										echo '<div class="form-group col-sm-6" style="height: 68px;">';
										echo '<label class="col-sm-5 control-label">'.$field->name.'</label>';
										echo '<div class="col-sm-7">';
										if($field->type=="checkbox" ){
											echo '<div class="switch-button switch-button-info">';
											echo '<input class="activeInput" type="checkbox" name="'.$field->field.'" id="'.$field->field.'"><span>';
											echo '<label for="'.$field->field.'"></label></span>';
											echo '</div>';
										}else if($field->type=="combobox" ){
											echo '<select class="form-control activeInput" name="'.$field->field.'">
											  <option value="0">-select gender-</option>
											  <option value="1">male</option>
											  <option value="2">female</option>
											</select>';
										}
										else{
											echo '<input id="'.$field->field.'" type="'.$field->type.'" name="'.$field->field.'" class="form-control activeInput" value="">';
										}
										echo '</div></div>';
									} ?>
								</div>
							</div>
					   
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php }?>
	
</div>



	
<form method="post" id="theForm" action="editusers">
<input id="theFormid" type="hidden" name="id" value="1">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>


function criar_menuitem(){
	var map = {};
	$(".activeInput").each(function() {
		if($(this).attr("type")=="checkbox"){
			if(document.getElementById($(this).attr("id")).checked){
				bit =1;
			}else{
				bit =0;
			}
			map[$(this).attr("name")] = bit;
		}else{
			map[$(this).attr("name")] = $(this).val();
		}
	
	});
	
	var title =  $('#title').val();
	var url =  $('#url').val();
	var position =  $('#position').val();
	var id =<?php if (isset($plugin->id)) {echo $plugin->id;}else{ echo 0;}?>;
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_users"); ?>',
		async: false,
		data:{	
				'fields':map,			
					},
		success:function(data){
			alert(JSON.stringify(data));
			edit_item(data,1,"Sucesso! ","Menu Gravado com successo");
			
		},
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou ao Gravar!");
		} 
	});
}

function update_menuitem(){
	var map = {};
	var bit = 0;
	$(".activeInput").each(function() {
		if($(this).attr("type")=="checkbox"){
			if(document.getElementById($(this).attr("id")).checked){
				bit =1;
			}else{
				bit =0;
			}
			map[$(this).attr("name")] = bit.toString(2);
		}else{
			map[$(this).attr("name")] = $(this).val();
		}
	
	});
		
	var id =<?php if (isset($user->id)) {echo $user->id;}else{ echo 0;}?>;

	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_users"); ?>',
		async: false,
		data:{	
				'fields':map,
				'id':id				
					},
		success:function(data){
			//alert(JSON.stringify(data));
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

