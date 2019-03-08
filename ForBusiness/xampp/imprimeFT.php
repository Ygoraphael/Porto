<?php
	$url = 'http://fullwear.no-ip.org:8080/intranet/ws/wscript.asmx?WSDL';
	$stamp = "c06-430b-923c-0e638edebaa";
	
	$user_param = array (
		'userName' => "api00001",
		'password' => "+(5dWBLv;~BHWETq",
		'code' => "imprimeFT",
		'parameter' => "<ftstamp>" . $stamp . "</ftstamp>"
	);

	$client = new SoapClient($url);
	$objectresult = $client->Runcode($user_param);
	$pdf_decoded = base64_decode($objectresult->RunCodeResult);

	$pdf = fopen ($stamp . '.pdf','w');
	fwrite ($pdf, $pdf_decoded);
	fclose ($pdf);
	echo 'Ficheiro criado com sucesso';
?>
	