<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button type="button" class="btn btn-info pull-right">Clone product</button>
		<button type="button" class="btn btn-info pull-right" style="margin-right:15px;">Disable product</button>
		<a target="_blank" href="<?php echo base_url()."product/".$product["u_sefurl"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;">View online</a>
		<a target="_blank" href="<?php echo base_url()."wl/".$_SESSION["backoffice_user_id"]."/product/".$product["u_sefurl"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;">View online WL</a>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="row form-group">
			<div class="col-xs-12">
				<?php echo $this->template->partial->view('backoffice-product-menu'); ?>
			</div>
		</div>
		<div class="row setup-content" id="step-1">
			<div class="col-xs-12">
				<div class="col-md-12 well text-center">
					<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix">
						<span>
							<h3>TICKETS NUMBER</h3>
							<table id="ticket_num_table" class="table table-striped table-bordered" cellspacing="0" >
								<thead>
									<tr>
										<th>Number</th>
										<th>Issued</th>
										<th>Used</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$tick_id = 0; 
										foreach( $u_pntick as $pnticket ) { ?>
									<tr>
										<td class="nopaddingmargin" tick_id="<?php echo $tick_id; ?>" stamp="<?php echo $pnticket["u_pntickstamp"]; ?>"><input type="text" class="form-control" value="<?php echo $pnticket["no"]; ?>"></td>
										<td class="nopaddingmargin"><input type="checkbox" <?php echo $pnticket["issued"] ? "checked": ""; ?> disabled ></td>
										<td class="nopaddingmargin"><input type="checkbox" <?php echo $pnticket["used"] ? "checked": ""; ?> disabled ></td>
										<td class="text-center nopaddingmargin"><a href="#" onclick="delete_tick_num(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
									</tr>
									<?php 
										$tick_id++; 
										} 
									?>
								</tbody>
							</table>
							<div class="col-lg-12 col-sm-12">
								<button type="button" id="ticket_num_table_add" class="btn btn-info btn-lg pull-left">Add ticket number</button>
								<button type="button" id="ticket_num_table_import" class="btn btn-info btn-lg pull-left">Import ticket numbers</button>
								<input class="hide" type="file" id="ticket_num_table_import_input">
							</div>
						</span>
					</form>
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left">SAVE PRODUCT</button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left">CANCEL</button>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$next; ?>"  class="btn btn-primary btn-lg pull-right">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>