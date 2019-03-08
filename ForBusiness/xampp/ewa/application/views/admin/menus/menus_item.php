<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<div class="row">
	
	
	<?php if($id_post != 0){ ?>
		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#home">Definições</a></li>
		   <li><a data-toggle="tab" href="#menu1">Permissões</a></li>
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
									<input id="title" type="text" class="form-control" value="<?php echo $menu_byid->text;?>">
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="panel panel-default">
								 <div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">TYPE</label>
										<div class="col-sm-9">
										<select id="type" class="form-control">
											<option <?php echo ( $menu_byid->type == "user_data" ? 'selected=""' : "" ) ?>>user_data</option>
											<option <?php echo ( $menu_byid->type == "login_popup" ? 'selected=""' : "" ) ?>>login_popup</option>
											<option <?php echo ( $menu_byid->type == "url" ? 'selected=""' : "" ) ?>>url</option>
											<option <?php echo ( $menu_byid->type == "language" ? 'selected=""' : "" ) ?>>language</option>
											<option <?php echo ( $menu_byid->type == "currency" ? 'selected=""' : "" ) ?>>currency</option>
										</select>
									</div>								  
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">URL</label>
										<div class="col-sm-9">
											<input id="url" type="text" class="form-control" value="<?php echo $menu_byid->url;?>">
										</div>
									</div>
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">CATEGORY</label>
											<div class="col-sm-9">
												<select id="category" class="form-control"  onchange="order_item(this.value);">
												<?php 
													foreach ($comboboxcategory->result() as $row) {
														if($category_id == $row->id ){
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
										<div class="form-group">
											<label class="col-sm-3 control-label">PARENT</label>
											<div class="col-sm-9">
												<select id="parent" class="form-control"  onchange="order_item(this.value);">
												<?php 
													if($menu_byid->parent == "0" ) {
												?>
													<option value="0" selected>-PARENT-</option>
												<?php }else{?>
													<option value="0">-PARENT-</option>
												<?php
													}
													foreach ($comboboxparent->result() as $row) {
														if($row->id == $menu_byid->parent ){
															?>
														<option value="<?php echo $row->id; ?>" selected><?php echo $row->text; ?></option>
												<?php
														} 
												?>
													<option value="<?php echo $row->id; ?>"><?php echo $row->text; ?></option>
												<?php
												}?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">ORDER</label>
											<div class="col-sm-9">
												<select id="order" class="form-control">
												</select>
											</div>
										</div>
									</div>
							  </div>
						   </div>
						</div>
					</div>
				</div>
				
				<!--- TAB 2 -->
				<div id="menu1" class="tab-pane fade">
					<div class="row">
						<div class="panel panel-default">						
							<div class="col-md-6">
							  <div class="panel panel-default">
								 <div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">Logged Only</label>
										<div class="col-sm-6 xs-pt-5">
											<div class="switch-button switch-button-info">
												<?php if($menu_byid->logged_only == "1"){?>
													<input type="checkbox" name="logged_only" id="logged_only" checked><span>
												<?php }else{?>
													<input type="checkbox" name="logged_only" id="logged_only"><span>
												<?php }?>
												<label for="logged_only"></label></span>
											</div>
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
		   <li><a data-toggle="tab" href="#menu1">Permissões</a></li>
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
										<label class="col-sm-3 control-label">TYPE</label>
										<div class="col-sm-9">
										<select id="type"class="form-control">
											<option>user_data</option>
											<option>login_popup</option>
											<option>url</option>
											<option>language</option>
											<option>currency</option>
										</select>
									</div>								  
									</div>
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
											<label class="col-sm-3 control-label">CATEGORY</label>
											<div class="col-sm-9">
												<select id="category" class="form-control"  onchange="order_item(this.value);">
												<?php 
													foreach ($comboboxcategory->result() as $row) {
												?>
													<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
												<?php
													}?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label">PARENT</label>
											<div class="col-sm-9">
												<select id="parent" class="form-control"  onchange="order_item(this.value);">
												
													<option value="0" selected>-PARENT-</option>
												<?php
													foreach ($comboboxparent->result() as $row) {
												?>
													<option value="<?php echo $row->id; ?>"><?php echo $row->text; ?></option>
												<?php
												}?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">ORDER</label>
											<div class="col-sm-9">
												<select id="order" class="form-control">
												</select>
											</div>
										</div>
									</div>
							  </div>
						   </div>
						</div>
					</div>
				</div>
				
				<!--- TAB 2 -->
				<div id="menu1" class="tab-pane fade">
					<div class="row">
						<div class="panel panel-default">						
							<div class="col-md-6">
							  <div class="panel panel-default">
								 <div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">Logged Only</label>
										<div class="col-sm-6 xs-pt-5">
											<div class="switch-button switch-button-info">
													<input type="checkbox" name="logged_only" id="logged_only"><span>
												<label for="logged_only"></label></span>
											</div>
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
	
	
<form method="post" id="theForm" action="menusitemnew">
<input id="theFormid" type="hidden" name="id" value="1">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
order_item($('#parent').find('option:selected').val());
function order_item(id){
	var max = 1;
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/order"); ?>',
		data:{'id':id},
		success:function(data){
			var obj = JSON.parse(data);
			document.getElementById('order').innerHTML = "";
			if(obj.length == 0){
				$('#order').append( new Option('1','1') );
			}else{
			$.each(obj, function(index, value) {
				<?php if($id_post != 0){ ?>
				if(value["lorder"] == <?php echo $menu_byid->lorder;?> && <?php echo $menu_byid->lorder;?> != 0 ){ 
					$('#order').append( "<option selected value='"+value['lorder']+"'>"+value['lorder']+"</option>");
				}else{
					$('#order').append( "<option value='"+value['lorder']+"'>"+value['lorder']+"</option>");
				}
				<?php }else{?>
				$('#order').append( "<option value='"+value['lorder']+"'>"+value['lorder']+"</option>");
				<?php }?>
				max = value["lorder"];
			});
			max=Number(max)+1;
			
			<?php if($id_post == 0){ ?> $('#order').append( '<option selected value="'+max+'">'+max+'</option>' ); <?php }?>
			}
		}
	});
}


function criar_menuitem(){
	
	var text = $('#title').val();
	var url = $('#url').val();
	var parent = $('#parent').val();
	var category_id = $('#category').val();
	if ($('#logged_only').is(":checked")){
		var logged_only = 1;
	}else{var logged_only=0;}
	var type = $('#type').val();
	var lorder = $('#order').val();
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_menu_item"); ?>',
		async: false,
		data:{	'text':text,
				'url':url,
				'parent':parent,
				'category_id':category_id,
				'logged_only':logged_only,
				'type':type,					
				'lorder':lorder,					
					},
		success:function(data){
			edit_item(data,1,"Sucesso! ","Menu Inserido com successo");
			
		},
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou a inserir");
		} 
	});
}




function update_menuitem(){
	var id =<?php if (isset($menu_byid->id)) {echo $menu_byid->id;}else{ echo 0;}?>;
	var logged_only='0';
	var text = $('#title').val();
	var url = $('#url').val();
	var parent = $('#parent').val();
	var category_id = $('#category').val();
	if ($('#logged_only').is(":checked")){
		logged_only = '1'; 
	}else{
		logged_only='0';}
	var type = $('#type').val();
	var lorder = $('#order').val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_menu_item"); ?>',
		async: false,
		data:{	'id':id,
				'text':text,
				'url':url,
				'parent':parent,
				'category_id':category_id,
				'logged_only':logged_only,
				'type':type,					
				'lorder':lorder,					
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
	var id =<?php if (isset($menu_byid->id)) {echo $menu_byid->id;}else{ echo 0;}?>;
	values.push(id);
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
				window.history.back();
			}
		});
	}
	
   
});

</script>