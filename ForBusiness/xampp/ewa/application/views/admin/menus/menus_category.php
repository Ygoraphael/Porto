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
									<input id="title" type="text" class="form-control" value="<?php echo $menu_byid->title;?>">
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="panel panel-default">
								 <div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">Name</label>
										<div class="col-sm-9">
											<input id="name" type="text" class="form-control" value="<?php echo $menu_byid->name;?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">URL</label>
										<div class="col-sm-9">
											<input id="url" type="text" class="form-control" value="<?php echo $menu_byid->url;?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Logo</label>
										<div class="col-sm-9">
											<input id="logo" type="text" class="form-control" value="<?php echo $menu_byid->logo;?>">
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
												<input id="position" type="text" class="form-control" value="<?php echo $menu_byid->position;?>">
											</div>
										</div>							
										<div class="form-group">
											<label class="col-sm-3 control-label">Toogle</label>
											<div class="col-sm-6 xs-pt-5">
												<div class="switch-button switch-button-info">
													<?php if($menu_byid->toggle == "1"){?>
														<input type="checkbox" name="toggle" id="toggle" checked><span>
													<?php }else{?>
														<input type="checkbox" name="toggle" id="toggle"><span>
													<?php }?>
													<label for="toggle"></label></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Type</label>
											<div class="col-sm-9">
												<select id="type" class="form-control">
													<option <?php echo ( $menu_byid->type == 1 ? 'selected=""' : "" ) ?> value="1">1</option>
													<option <?php echo ( $menu_byid->type == 2 ? 'selected=""' : "" ) ?> value="2">2</option>
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
										<label class="col-sm-3 control-label">Name</label>
										<div class="col-sm-9">
											<input id="name" type="text" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">URL</label>
										<div class="col-sm-9">
											<input id="url" type="text" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Logo</label>
										<div class="col-sm-9">
											<input id="logo" type="text" class="form-control" value="">
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
												<input id="position" type="text" class="form-control" value="">
											</div>
										</div>							
									
										<div class="form-group">
											<label class="col-sm-3 control-label">Toogle</label>
											<div class="col-sm-6 xs-pt-5">
												<div class="switch-button switch-button-info">
														<input type="checkbox" name="toggle" id="toggle"><span>
													<label for="toggle"></label></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Type</label>
											<div class="col-sm-9">
												<select id="type" class="form-control">
													<option value="1">1</option>
													<option value="2">2</option>
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
				</div>
			</div>
		</form>
		
	<?php		
	}?>
	
</div>	
	
	
<form method="post" id="theForm" action="menuscategorynew">
<input id="theFormid" type="hidden" name="id" value="1">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
function criar_menuitem() {
	var title = $('#title').val();
	var url = $('#url').val();
	var position = $('#position').val();
	var logo = $('#logo').val();
	var name = $('#name').val();
	var type = $('#type').val();
	if ($('#toggle').is(":checked")){
		var toggle = 1;
	}else{var toggle=0;}
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_menu_category"); ?>',
		async: false,
		data:{	'title':title,
				'url':url,
				'position':position,
				'logo':logo,
				'toggle':toggle,					
				'name':name,					
				'type':type					
					},
		success:function(data){
			edit_item(data,1,"Sucesso! ","Menu Inserido com successo");
			
		},
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou a inserir");
		} 
	});
}




function update_menuitem() {
	var id =<?php if (isset($menu_byid->id)) {echo $menu_byid->id;}else{ echo 0;}?>;
	var toggle='0';
	var title = $('#title').val();
	var url = $('#url').val();
	var position = $('#position').val();
	var logo = $('#logo').val();
	var name = $('#name').val();
	var type = $('#type').val();
	if ($('#toggle').is(":checked")){
		var toggle = 1;
	}else{var toggle=0;}

	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_menu_category"); ?>',
		async: false,
		data:{	'id':id,
				'title':title,
				'url':url,
				'position':position,
				'logo':logo,
				'toggle':toggle,					
				'name':name,					
				'type':type					
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
			url: "<?php echo base_url(); ?>admin/ajax/delete_menucat",
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