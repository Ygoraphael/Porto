<style>
.titulo {
	font-weight:bold;
}

.policy {
	margin-bottom:15px;
}

.policy li{
	list-style-type: none;
}

</style>
<div class="container policy">
	<div class="col-lg-12">
		<span class="titulo">Is buying by credit card safe?</span><br><br>
		The purchase by credit card is safe for the following reasons:
		<ul>
		<li>The connection of our servers to the banking operator's servers (UNICRE) is done through an encrypted (secure) connection to 128 bits. This degree of encryption is usually used for home banking.</li>
		<li>We use a 128-bit digital certificate to ensure the security of the exchange of your credit card information between your computer and our servers.</li>
		<li>Your credit card data is not stored on our servers except for the last 4 digits and expiration date, which is also stored in a local database for customer support.</li>
		</ul>
		<br>
		<span class="titulo">How can I check the security of my credit card purchase?</span><br><br>
		<ul>
		<li>Check your Browser Address for the URL if the address begins with https: // when you are prompted for your credit card information.</li>
		</ul>
		<br>Please confirm the following:<br>
		<ul>
		<li>Internet Explorer: yellow padlock at the top of the page</li>
		<li>Mozillla Firefox: yellow padlock at the top of the page</li>
		<li>Google Chrome: green padlock at the top of the page</li>
		<li>Click the icon and make sure the certificate is in the name of: payment.soft4booking.com</li>
		</ul>
		<br>
		If you still have questions about electronic payment security, you can always opt for other forms of payment.
		<br><br>
		<span class="titulo">What are the guarantees that my order will be processed?</span><br><br>
		SOFT4BOOKING will ensure that your order is handled in a correct, timely and diligent manner. If you have any questions or problems, please do not hesitate to contact our customer service department at info@globalfragments.com or by calling (+351) 224 100 682.
		<br><br>
		<span class="titulo">THIS SITE IS ACKNOWLEDGED AS: VERIFIED BY VISA, GUARANTEEING THE CONFIDENTIALITY OF ITS DATA AS WELL AS THE SAFETY IN THE ACT OF PAYMENT BY CREDIT CARD.</span><br><br>
	</div>
	<div class="col-lg-12">
		<div class="pull-left" style="margin-right:15px;">
			<img src="<?php echo base_url() ?>img/redunicre.png" border="0" style="height:184px">
		</div>
		<div class="pull-left" style="margin-right:15px;">
			<a onclick="verified_popup()"><img class="" src="<?php echo base_url() ?>img/VerifiedByVisa-Learnmore.gif" border="0" style="height:88px;margin-bottom:5px;"></a><br>
			<a onclick="return windowpop('http://www.mastercard.com/us/business/en/corporate/securecode/sc_popup.html?language=pt', 560, 400)">
				<img class="" src="<?php echo base_url() ?>img/sc_learn_156x83.gif" border="0" style="height:88px">
			</a>
		</div>
		<div class="pull-left">
			<img class="" src="<?php echo base_url() ?>img/paypal.png" border="0" style="height:88px;margin-bottom:5px;"><br>
			<img class="" src="<?php echo base_url() ?>img/multibanco.png" border="0" style="height:88px">
		</div>
	</div>
</div>

<script>
	function windowpop(url, width, height) {
		var leftPosition, topPosition;
		//Allow for borders.
		leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
		//Allow for title and status bars.
		topPosition = (window.screen.height / 2) - ((height / 2) + 50);
		//Open the window.
		window.open(url, "Window2", "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
	}

	function verified_popup() {
		var dialog = bootbox.dialog({
			message: '<p class="text-center"><img class="" src="<?php echo base_url() ?>img/verified1.png" border="0"></p>',
			closeButton: true,
			onEscape:true,
			backdrop: true
		});
	}
</script>