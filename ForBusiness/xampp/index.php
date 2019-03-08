<?php
	$url = 'http://fullwear.no-ip.org:8080/intranet/ws/wscript.asmx?WSDL';
	
	$user_param = array (
		'userName' => "api00001",
		'password' => "+(5dWBLv;~BHWETq",
		'code' => "criaFT",
		'parameter' => "<header><intid>666</intid><nome>Tiago Loureiro</nome><morada>Rua de Vilar, 235 6o D</morada><codpost>4050-626</codpost><local>PORTO</local><ncont>123456789</ncont></header><items><item><ref>FS-0148</ref><design>FS-0148 AAAAA</design><cor></cor><tam></tam><qtt>10.00</qtt><epv>100.00</epv><desconto>0.00</desconto><ivaincl>0</ivaincl><iva>2</iva></item><item><ref></ref><design>Inscrição 1</design><cor></cor><tam></tam><qtt>0.00</qtt><epv>0.00</epv><desconto>0.00</desconto><ivaincl>0</ivaincl><iva>2</iva></item></items>"
	);

	$client = new SoapClient($url);
	$objectresult = $client->Runcode($user_param);
	$stamp = $objectresult->RunCodeResult;
	print_r($stamp);
?>
	