<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button type="button" onclick="clone_product('<?php echo trim($product["bostamp"]); ?>'); return false;" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("Clone product", $_SESSION['lang_u']); ?></button>
		<a target="_blank" href="<?php echo base_url()."product/".$product["u_sefurl"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;"><?php echo $this->translation->Translation_key("View online", $_SESSION['lang_u']); ?></a>
		<a target="_blank" href="<?php echo base_url()."wl/".$_SESSION["backoffice_user_id"]."/product/".$product["u_sefurl"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;"><?php echo $this->translation->Translation_key("View online WL", $_SESSION['lang_u']); ?></a>
	</div>
</div>