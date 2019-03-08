<?php
    define( '_JEXEC', 1); //  This will allow to access file outside of joomla.
    define( 'DS', DIRECTORY_SEPARATOR );
    define( 'JPATH_BASE', realpath(dirname(__FILE__) .'/' ) );
    require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
    require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
    
    $db = JFactory::getDBO();
	
	$nome = 	 $_POST['nome'];
	$dtnasc = 	 $_POST['dtnasc'];
	$bi = 		 $_POST['bi'];
	$conc = 	 $_POST['conc'];
	$telem = 	 $_POST['telem'];
	$email = 	 $_POST['email'];
	$socio = 	 $_POST['socio'];
	$num_socio = $_POST['num_socio'];
	
	$query = $db->getQuery(true);
	$profile = new stdClass();
	$profile->ano=date("Y");
	$profile->nome=$nome;
	$profile->data_nasc=$dtnasc;
	$profile->bicc=$bi;
	$profile->concelho=$conc;
	$profile->telemovel=$telem;
	$profile->email=$email;
	$profile->socio_bt=$socio;
	$profile->num_socio_bt=$num_socio;
	$profile->pago="Não";
	
	$result = JFactory::getDbo()->insertObject('inscricoes', $profile);
	echo $result;
	
	$mailer = JFactory::getMailer();
	$sender = array( 
		'geral@portoantigo.pt',
		'Porto Antigo'
	);
	$mailer->setSender($sender);
	$recipient = $email; 
	$mailer->addRecipient($recipient);
	$body   = "Olá,<br><br>
			Recebemos correctamente a sua inscrição no passeio Porto Antigo.<br>
			Relembramos que para concluír a sua inscrição terá que efectuar o pagamento via transferência bancária!<br>
			Sócio Bike Team - 8 euros<br>
			Não sócio - 10 euros<br><br>
			Enviamos aqui os dados multibanco para pagamento:<br><br>
			0010 0000 446 825 90 001 84<br><br><br><br>
			Obrigado!";
	$mailer->isHTML(true);
	$mailer->Encoding = 'base64';
	$mailer->setSubject('Inscrição Porto Antigo');
	$mailer->setBody($body);
	
	$send = $mailer->Send();
	
	$mailer = JFactory::getMailer();
	$sender = array( 
		'geral@portoantigo.pt',
		'Porto Antigo'
	);
	$mailer->setSender($sender);
	$recipient = "paulo@patocycles.com"; 
	$mailer->addRecipient($recipient);
	$body   = "Olá,<br><br>
			Foi efectuada uma inscrição no passeio Porto Antigo.<br>
			Dados:<br>
			Nome: ".$nome."<br>
			Data de Nascimento: ".$dtnasc."<br>
			Bi ou CC: ".$bi."<br>
			Concelho: ".$conc."<br>
			Telemóvel: ".$telem."<br>
			Email: ".$email."<br>
			Sócio Bike Team: ".$socio."<br>
			Nº Sócio Bike Team: ".$num_socio;
	$mailer->isHTML(true);
	$mailer->Encoding = 'base64';
	$mailer->setSubject('Inscrição Porto Antigo');
	$mailer->setBody($body);
	
	$send = $mailer->Send();
	
 
?>