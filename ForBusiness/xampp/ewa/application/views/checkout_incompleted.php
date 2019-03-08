<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="col-lg-12">
	<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
	<legend style="color:white;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Checkout'); ?></legend>
	<div class="col-lg-12">
		<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Cant complete your checkout now. Try again later.'); ?>
	</div>
</div>