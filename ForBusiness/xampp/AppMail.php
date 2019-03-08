<?php
error_reporting(0); 
ini_set('display_errors', '0');

function verifyEmail($email) {
    if (!preg_match("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $email))
        return false;
    list($prefix, $domain) = explode("@", $email);
    if (function_exists("getmxrr") && getmxrr($domain, $mxhosts))
        return true;
    elseif (@fsockopen($domain, 25, $errno, $errstr, 5))
        return true;
    else
        return false;
}

function limpaString($str, $tipo=''){
    //$str = mysql_real_escape_string($str);
    $str = addslashes($str);
    switch ($tipo) {
        case 'int': $str = preg_replace('/[^0-9.]/','',$str); break;
        case 'str': $str = preg_replace('/[^A-Za-zéÉíÍóÓõáÁàãç ]/','',$str); break;
        case 'str_int': $str = preg_replace('/[^A-Za-z0-9]/','',$str); break;
    }
    return $str;
}

function sendMailGeral2($assunto, $corpo, $destinatario) {
		require 'PHPMailer/PHPMailerAutoload.php';
		
        $corpo = utf8_decode("<html><head><meta charset='utf-8'></head><body>$corpo</body></html>");
        $from = $_POST['email'];
		$from_name = $_POST['nome'];
        $to = $destinatario;
        $subject = $assunto;
 
		$mail = new PHPMailer(true);
		try {
			//Server settings
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host = 'smtp.ptempresas.pt';
			$mail->SMTPAuth = true;
			$mail->Username = 'geral@gaplda.pt';
			$mail->Password = '080gap000';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			//Recipients
			$mail->setFrom($from, $from_name);
			$mail->addAddress($to);

			//Content
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $corpo;
			$mail->AltBody = $corpo;

			$mail->send();
			return true;
		} 
		catch (Exception $e) {
			//error_log('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
			return false;
		}
	}
?>