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
							<h3><?php echo $this->translation->Translation_key("RELATED PRODUCTS", $_SESSION['lang_u']); ?></h3>
						</span>
						<table id="relprod_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></th>
									<th class="text-center"><?php echo $this->translation->Translation_key("Activated", $_SESSION['lang_u']); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							foreach( $products as $prod ) {
								if( $prod["bostamp"] != $product["bostamp"] ) {
									$in_relprod = 0;
									foreach( $related_products as $related_product ) {
										if( $related_product["relprodbostamp"] == $prod["bostamp"] )
											$in_relprod = 1;
									}
							?>
								<tr>
									<td class="text-left" stamp="<?php echo $prod["bostamp"]; ?>"><?php echo $prod["u_name"]; ?></td>
									<td>
										<div class="am-checkbox" style="text-align: -webkit-center;">
											<input type="checkbox" id="<?php echo $prod["bostamp"]; ?>" <?php echo ($in_relprod == 1) ? "checked": ""; ?> />
											<label for="<?php echo $prod["bostamp"]; ?>"></label>
										</div>
									</td>
								</tr>
							<?php } 
								}
							?>
							</tbody>
						</table>
					</form>
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE PRODUCT", $_SESSION['lang_u']); ?></button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("CANCEL", $_SESSION['lang_u']); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>