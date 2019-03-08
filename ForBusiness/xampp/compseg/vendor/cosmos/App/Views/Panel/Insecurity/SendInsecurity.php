<?php

use Cosmos\System\Template;

$Insecurity = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);

$user2 = (App\Model\User::getUserLoged()->getUser_type() );

    $tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/sendInsecurity.html');

	$parameters = [
	'deleted' => ['<', 1]
	];
	$users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
	
	foreach ($users as $user) {
		$user = (new App\Model\User)->fetch($user->user);
		$tpl->CODE = $user->getId();
		$tpl->NAME = $user->getName();
		$tpl->SURNAME = $user->getLast_name();
		$tpl->block('BLOCK_USER');
	}
	$tpl->block('BLOCK_USERS');
	$tpl->Insecurity = $Insecurity;
	
	$insecuritys = (new \App\Model\Insecurity())->fetch($Insecurity);
	if($insecuritys){
		$COMMENT = $insecuritys->getComment();
		$tpl->COMMENT = "<li><p>".str_replace("+","</li><li><p>",$COMMENT)."<p></li>";
		$tpl->comment2 = $COMMENT;
	}
	
    $tpl->show();
