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
							   <th><b><?php echo $this->translation->Translation_key("Cash Parcial Payment Percentage", $_SESSION['lang_u']); ?></b></th>
							   <th><b><?php echo $this->translation->Translation_key("Fee", $_SESSION['lang_u']); ?></b></th>
							</tr>
						 </thead>
						 <tbody>
						 <?php 
						 $string ="";
							foreach($productfee as $row){
						?>
							<tr stamp="<?php echo $row['bostamp']; ?>" ins="">
							   <td><?php echo $row['name']; ?></td>						   
							   <td >
									<input type="number" class="form-control" id="perparcial" name="perparcial" min="0" max="100" value="<?php echo number_format($row['perparcial'], 2, '.', ''); ?>">
							   </td>
							   <td >
									<input type="number" class="form-control" id="perparcial" name="perparcial" min="0" max="100" value="<?php echo number_format($row['fee'], 2, '.', ''); ?>">
							   </td>
							</tr>
						 <?php } ?>
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
	
	var string = "";
	var ins = 0;
	var bostamp = "";
	var comissao = 0;
	var ok = 1;
	
	var agent_product_fee_table = Array();
	jQuery( "#agent_product_fee_table tbody tr" ).each(function(){
		var agent_product_fee_table_tmp = new Array();
		var stamp = jQuery(this).attr("stamp");
		agent_product_fee_table_tmp.push(jQuery(this).attr("stamp"));
		agent_product_fee_table_tmp.push(jQuery(this).attr("ins"));
		agent_product_fee_table_tmp.push( jQuery(this).children().eq(0).html() );
		agent_product_fee_table_tmp.push( jQuery(this).children().eq(1).find("input").val() );
		agent_product_fee_table_tmp.push( jQuery(this).children().eq(2).find("input").val() );
		agent_product_fee_table.push(agent_product_fee_table_tmp);
		
		if( parseFloat(jQuery(this).children().eq(1).find("input").val()) < 0 || parseFloat(jQuery(this).children().eq(2).find("input").val()) < 0 ) {
			ok = 0;
		}
		else if( parseFloat(jQuery(this).children().eq(1).find("input").val()) > 100 || parseFloat(jQuery(this).children().eq(2).find("input").val()) > 100 ) {
			ok = 0;
		}
	});
	
	if( ok == 1 ) {
		$(".loading-overlay").show();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/agent_product_manage_fee",
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
					"message": "Product's Fee updated successfully",
					"priority": 'success'
				}
				]);
			}
		});
	}
	else {
		bootbox.alert("All values must be higher or equal to 0 and smaller or equal to 100");
	}
}
</script>