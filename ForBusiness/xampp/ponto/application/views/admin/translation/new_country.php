<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<div class="row">

	<?php if($code != ""){ ?>
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
										<label class="col-sm-3 control-label">Country</label>
										<div class="col-sm-9">
											<input id="country" type="text" class="form-control" value="<?php echo $country->language;?>" >
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
							<div class="col-md-6">
							  <div class="panel panel-default">
								<div class="panel-body">
										<div class="form-group">
										<label class="col-sm-3 control-label">Country</label>
										<div class="col-sm-9">
											<input id="country" type="text" class="form-control" value="" >
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



	
<form method="post" id="theForm" action="edit_countries">
<input id="theFormid" type="hidden" name="id" value="1">
<input id="theFormerror" type="hidden" name="error" value="1">
<input id="text1" type="hidden" name="text1" value="">
<input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>

function criar_menuitem(){
	var country =  $('#country').val();
	var flag =  $('#flag').val();
	var code =  $('#code').val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/create_country"); ?>',
		async: false,
		data:{	'country':country,
				'flag':flag,
				'code':code		
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
	var country =  $('#country').val();
	var flag =  $('#flag').val();
	var code =  $('#code').val();
	
	$.ajax({
		type:'POST',
		url:'<?php echo base_url("admin/update_country"); ?>',
		async: false,
		data:{	
				'country':country,
				'flag':flag,
				'code':code					
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

