<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="col-lg-12">
	<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
	<legend style="color:white;">Checkout</legend>
	<div class="col-lg-12">
		<div style="background:url(<?php echo base_url(); ?>img/Howdy.png);background-size:cover;text-align:right;min-height:350px;">
			<div class="col-lg-4"></div>
			<div class="col-lg-8" style="padding-top:50px">
				<h2 style='font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;font-weight: normal;'>
				Howdy <?php if($client_type == "agent") { echo $PaymentData["pay_client_name"]; } else { echo $user["first_name"] . ' ' . $user["last_name"]; } ?>,
				<br>
				Thank you for booking with a member EWA\European World Alliance.
				<br>
				Your payment has been processed.
				In a few minutes you will receive your ticket.
				<br>
				However, if any of unexpected, contact us via ticket@soft4payment.com
				<br><br>
				</h2>
			</div>
		</div>
	</div>
</div>