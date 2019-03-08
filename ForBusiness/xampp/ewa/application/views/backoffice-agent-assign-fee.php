<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>			
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
			</div>
		</div>
		
		<div class="main-content col-sm-12">
		   <div class="panel panel-default">
			 <div class="col-sm-12">
				   <div class="widget widget-fullwidth widget-small">
					
					  <table class="table table-condensed table-hover table-striped  table-fw-widget" id="agent_product_fee_table">
						 <thead>
							<tr>
							   <th><b><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></b></th>
							   <th style="text-align: -webkit-center;"><b><?php echo $this->translation->Translation_key("Assign", $_SESSION['lang_u']); ?></b></th>
							</tr>
						 </thead>
						 <tbody>
						 <?php 
						 $string ="";
						 $count=0;
							foreach($productfee as $row){
						?>
							<tr stamp="<?php echo $row['bostamp']; ?>" ins="<?php echo $row['ins']; ?>">
								<td><?php echo $row['name']; ?></td>						   
								<td class="nopaddingmargin" >
								<?php
								
								if($row['ins'] == 1){
								?>
								<div class='am-checkbox' style="text-align: -webkit-center;">
										<input type='checkbox' id="<?php echo "check".$count; ?>" checked >
										<label for="<?php echo "check".$count; ?>" ></label>									
									</div>
								<?php
								}else{
								?>
								<div class='am-checkbox' style="text-align: -webkit-center;">
									<input type='checkbox' id="<?php echo "check".$count; ?>">
									<label for="<?php echo "check".$count; ?>" ></label>									
								</div>
								<?php	
								}
								?>
									
								</td>
							</tr>
						 <?php 
						 $count++;
						 } ?>
						 </tbody>
					  </table>
				   </div>
				   <p style="margin-bottom:25px"></p>
				   <div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
				   	<button style="margin-bottom:25px" onclick="save(); return false;" class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
				</div>
		   </div>
		</div>
	</div>
</div>
<script>
function save(){
	$(".loading-overlay").show();
	var string = "";
	var ins = 0;
	var bostamp = "";
	var comissao = 0;
	
	var agent_product_fee_table = Array();
	jQuery( "#agent_product_fee_table tbody tr" ).each(function(){
		var agent_product_fee_table_tmp = new Array();
		var stamp = jQuery(this).attr("stamp");
		agent_product_fee_table_tmp.push(jQuery(this).attr("stamp"));
		agent_product_fee_table_tmp.push(jQuery(this).attr("ins"));
		agent_product_fee_table_tmp.push( jQuery(this).children().eq(0).html() );
		agent_product_fee_table_tmp.push( jQuery(this).children().eq(1).find("input").is(":checked") );
		agent_product_fee_table.push(agent_product_fee_table_tmp);
	});
	
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/agent_product_fee",
		data: { 
			"agent_product_fee" : JSON.stringify(agent_product_fee_table), 
			"agent" : <?php echo $this->uri->segment(3); ?>
		},
		success: function(data) 
		{
			data=JSON.parse(data);

			jQuery( "#agent_product_fee_table tbody tr" ).each(function(){
				thiss = jQuery(this);
				data['agent_product_fee'].forEach(function(entry){
					if (entry[0] == thiss.attr("stamp")){						
						thiss.attr("ins", entry[1]) ;	
					}		
				})
			});

			$(".loading-overlay").hide();
			jQuery(document).trigger("add-alerts", [
			{
				"message": "Product's Assign updated successfully",
				"priority": 'success'
			}
			]);
		}
	});
	
}
</script>