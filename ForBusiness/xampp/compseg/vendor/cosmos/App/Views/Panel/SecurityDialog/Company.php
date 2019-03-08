<?php
$idProfile = $_GET['p'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/company.html');
$translate = (new \App\Model\Translate());
$parameters = [
    'deleted' => ['=', 0, 'AND']
];
if( $idProfile != 0){
	$parameters['profile'] = ['=', $idProfile, 'AND'];
}
$parameters['idSecurityDialog'] = ['>', 0, ''];
 
$dialogs = (new \App\Model\SecurityDialog)->listingRegisters($parameters);
if (!empty($dialogs)) {
    foreach ($dialogs as $dialog) {
        
        $profile = (new App\Model\Profile)->fetch($dialog->getProfile());
        $dialog->setProfile($profile->getName());
        $tpl->SECURITYDIALOG = $dialog;
        $tpl->block('BLOCK_SECURITYDIALOG');
    }
    $tpl->block('BLOCK_SECURITYDIALOGS');
}
else {
    $tpl->block('BLOCK_NO_USERS');
}

$parameters2 = [
    'deleted' => ['=', 0, '']
];
$profiles = (new App\Model\Profile)->listingRegisters($parameters2);
if($profiles){
	foreach($profiles as $profile){
		if($idProfile == $profile->getId()){
			$tpl->SELECTED = 'selected';
		} elseif($idProfile == 0) {
			$tpl->SELECTED2 = 'selected';
		}else{
			$tpl->SELECTED = '';
		}
		$tpl->IDPROFILE = $profile->getId();
		$PROFILE = (new \App\Model\Translate())->translater($profile->getName());
		$tpl->PROFILE = $PROFILE;
		$tpl->block('BLOCK_PROFILE');
	}	
}

$tpl->show();