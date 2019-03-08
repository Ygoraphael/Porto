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
							<h3>TYPE</h3>
							<div class="funkyradio">
							<?php
								foreach( $categ as $cg ) {
									if( sizeof($u_pcateg)> 0 )
										$category = $u_pcateg[0]['category'];
									else
										$category = "";
									
							?>
								<div class="funkyradio-primary col-lg-12">
									<input value="<?php echo $cg["u_categstamp"]; ?>" type="radio" name="u_pcateg.category" <?php echo ($category == $cg["category"]) ? "checked='checked'" : ""; ?> id="categ_<?php echo $cg["category"]; ?>" />
									<label class="text-left" for="categ_<?php echo $cg["category"]; ?>"><?php echo $cg["category"]; ?></label>
								</div>
							<?php
								}
							?>
							</div>
						</span>
					</form>
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left">SAVE PRODUCT</button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left">CANCEL</button>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$next; ?>"  class="btn btn-primary btn-lg pull-right">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>