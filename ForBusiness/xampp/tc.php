<?PHP
 
$no="00351912629971";
$apiToken="5vkhuU3l6h";  // PHPHive Truecaller API Token, Obtain it from https://tcapi.phphive.info/console/
 
$uri = 'https://tcapi.phphive.info/'.$apiToken.'/search/'.$no;
$ch = curl_init($uri);
curl_setopt_array($ch, array(
    CURLOPT_HTTPHEADER  => array('X-User: PHPHive'),
    CURLOPT_RETURNTRANSFER  =>true,
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_VERBOSE     => 1
));
$response = curl_exec($ch);
curl_close($ch);
echo $response;
 
?>