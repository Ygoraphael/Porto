<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php echo $this->template->partial->view('backoffice-product-top-bar', $data = array(), $overwrite = false); ?>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="row form-group">
			<div class="col-xs-12">
				<?php echo $this->template->partial->view('backoffice-product-menu', $data = array(), $overwrite = true); ?>
			</div>
		</div>
		<div class="row setup-content" id="step-1">
			<div class="col-xs-12">
				<div class="col-md-12 well text-center">
					<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix">
						<span>
							<h3><?php echo $this->translation->Translation_key("EXTRAS/RESOURCES", $_SESSION['lang_u']); ?></h3>
							<table id="extras_table" class="table table-striped table-bordered" cellspacing="0" >
								<thead>
								<tr>
								<th><?php echo $this->translation->Translation_key("Resource", $_SESSION['lang_u']); ?></th>
								<th><?php echo $this->translation->Translation_key("Quant", $_SESSION['lang_u']); ?>.</th>
								<th><?php echo $this->translation->Translation_key("Price", $_SESSION['lang_u']); ?></th>
								<th><?php echo $this->translation->Translation_key("Extra", $_SESSION['lang_u']); ?></th>
								<th><?php echo $this->translation->Translation_key("Per Ticket", $_SESSION['lang_u']); ?></th>
								<th><?php echo $this->translation->Translation_key("Activated", $_SESSION['lang_u']); ?></th>
								</tr>
								</thead>
								<tbody>
									<?php 
									foreach( $u_prec as $extra ) {
										$extra_found = 0;

										foreach( $u_pextra as $pextra ) {
											if( $extra["ref"] == $pextra["ref"] ) {
												$extra_found = 1;
												?>
												<tr>
												<td class="nopaddingmargin" ref="<?php echo $extra["ref"]; ?>" design="<?php echo $extra["design"]; ?>"><?php echo $extra["design"]; ?></td>
												<td class="nopaddingmargin" ><input type="number" class="form-control" value="<?php echo number_format($pextra["qtt"], 2, ".", ""); ?>"></td>
												<td class="nopaddingmargin" ><input type="number" class="form-control" value="<?php echo number_format($pextra["price"], 2, ".", ""); ?>"></td>
												<?php if($pextra["extra"] == 1){?>
												<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox" checked /></td>
												<?php }else{?>
												<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox"  /></td>
												<?php   
												}?>
												<?php if($pextra["varbilh"] == 1){?>
												<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox" checked /></td>
												<?php }else{?>
												<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox"  /></td>
												<?php   
												}?>
												<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox" checked /></td>
												</tr>
											<?php
											}
										}

										if( $extra_found == 0 ) {
											?>
											<tr>
											<td class="nopaddingmargin" design="<?php echo $extra["design"]; ?>" ref="<?php echo $extra["ref"]; ?>"><?php echo $extra["design"]; ?></td>
											<td class="nopaddingmargin" ><input type="number" class="form-control" value="0.00"></td>
											<td class="nopaddingmargin" ><input type="number" class="form-control" value="0.00"></td>
											<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox" /></td>
											<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox" /></td>
											<td class="text-center nopaddingmargin"><input name="extras_table.<?php echo $extra["ref"]; ?>" type="checkbox" /></td>
											</tr>
											<?php
										}
									} ?>
								</tbody>
								</table>

						</span>
					</form>
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span> <?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?></a>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE PRODUCT", $_SESSION['lang_u']); ?></button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("CANCEL", $_SESSION['lang_u']); ?></button>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$next; ?>"  class="btn btn-primary btn-lg pull-right"><?php echo $this->translation->Translation_key("NEXT", $_SESSION['lang_u']); ?> <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>