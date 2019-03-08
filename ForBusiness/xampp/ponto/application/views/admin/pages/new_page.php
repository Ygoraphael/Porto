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
									<input id="title" type="text" class="form-control" value="<?php echo $page->title;?>">
								 </div>
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-3 control-label">Alias</label>
										<div class="col-sm-9">
											<input id="alias" type="text" class="form-control" value="<?php echo $page->alias;?>" readonly>
										</div>
									</div>
								</div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
										
									</div>
							  </div>
						   </div>
						   <div class="col-md-12" >
								<div id="summernote" style="height:200px;">
									<?php echo $page->content;?>
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
										<label class="col-sm-3 control-label">Alias</label>
										<div class="col-sm-9">
											<input id="alias" type="text" class="form-control" value="" readonly>
										</div>
									</div>
								</div>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body">
			
									</div>
							  </div>
						   </div>
						   <div class="col-md-12" >
								<div id="summernote" style="height:200px;">
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



	
<form method="post" id="theForm" action="editpages">
<input id="theFormid" type="hidden" name="id" value="1">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>

$(document).ready(function() {
  $('#summernote').summernote({
	height: 300
  });
});
function criar_menuitem(){
	var title =  $('#title').val();
	var content = $('#summernote').summernote('code');
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/generate_seo_link2"); ?>',
		async: false,
		data:{	'title':title			
					},
		success:function(data){
			if(data == ""){
				create_page(title,content);
			}else{
				alert("alias já existe")
			}			
		},
		error: function(data) { 
			//edit_item(data,2,"Erro! ","Falhou a inserir");
				alert(JSON.stringify(data));
		} 
	});
}

function create_page(title,content){
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_item_pages"); ?>',
		async: false,
		data:{	'title':title,
				'content':content				
					},
		success:function(data){
			edit_item(data,1,"Sucesso! ","Página criada com successo");
			
		},
		error: function(data) { 
			edit_item(data,2,"Erro! ","Falhou a inserir");
		} 
	});
}



function update_menuitem(){
	var id =<?php if (isset($page->id)) {echo $page->id;}else{ echo 0;}?>;
	var title =  $('#title').val();
	var content = $('#summernote').summernote('code');
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_item_pages"); ?>',
		async: false,
		data:{	
				'id':id,
				'title':title,
				'content':content				
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

