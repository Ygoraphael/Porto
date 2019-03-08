<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="col-lg-12">
	<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
	<legend style="color:white;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Checkout'); ?></legend>
	<div class="col-lg-12">
		<div style="background:url(<?php echo base_url(); ?>img/Howdy.png);background-size:cover;text-align:right;min-height:350px;">
			<div class="col-lg-4"></div>
			<div class="col-lg-8" style="padding-top:50px">
				<h2 style='font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;font-weight: normal;'>
				<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Howdy'); ?> <?php if($client_type == "agent") {  } else { echo trim(trim($user["first_name"]) . ' ' . trim($user["last_name"])); } ?>,
				<br>
				<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Thank you for booking with a member EWA\European World Alliance.'); ?>
				<br>
				<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Your payment has been processed.'); ?>
				<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'In a few minutes you will receive your ticket.'); ?>
				<br>
				<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'However, if any of unexpected, contact us via ticket@soft4payment.com'); ?>
				<br>			
				<br>
				</h2>
			</div>
		</div>
		<br>
		<?php if($client_type == "agent") { ?>
		<button onclick="imprimir_ticket()" class="btn btn-primary btn-md" style="margin-bottom:15px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Print Ticket'); ?></button>
		<?php } ?>
		
	</div>
</div>
<script>
	function imprimir_ticket() {
		window.location.href = '<?php echo base_url(); ?>wl/<?php echo $op;?>/pdf/<?php echo $bostamp2;?>';
	}	
</script>