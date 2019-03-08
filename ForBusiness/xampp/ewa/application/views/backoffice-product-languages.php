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
						<table id="language_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th></th>
									<th style="text-align: -webkit-center;" ><h4><b><?php echo $this->translation->Translation_key("Languages", $_SESSION['lang_u']); ?></b></h4></th>
									<th>
										<div class="am-checkbox" style="text-align: -webkit-center;">
											<input type="checkbox" id="select_all">
											<label for="select_all"></label>							
										</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$variable = false;	
								foreach( $u_lang as $lang ) 
								{
									foreach( $u_plang as $language ) 
									{ 
										if(trim($language["language"]) == trim($lang["language"])){ 
											$variable = true;
										}
									}?>									
									<tr>
										<td><img src="<?php echo base_url(); ?>img/flags/<?php echo $lang["language"]; ?>.png" alt="<?php echo $lang["language"]; ?>"></td>
										<td stamp="<?php echo $lang["u_langstamp"]; ?>" language_val="<?php echo $lang["language"]; ?>" ><?php echo $lang["language"]; ?></td>
										<td class="nopaddingmargin">
											<div class="am-checkbox" style="text-align: -webkit-center;">
												<input type="checkbox" id="<?php echo $lang["u_langstamp"]; ?>" <?php echo ($variable) ? "checked": ""; ?>>
												<label for="<?php echo $lang["u_langstamp"]; ?>"></label>							
											</div>
										</td>
									</tr>
								<?php 
									$variable = false;										
								}?>

							</tbody>
						</table>
					</form>
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE PRODUCT", $_SESSION['lang_u']); ?></button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("CANCEL", $_SESSION['lang_u']); ?></button>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$next; ?>"  class="btn btn-primary btn-lg pull-right"><?php echo $this->translation->Translation_key("NEXT", $_SESSION['lang_u']); ?> <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>