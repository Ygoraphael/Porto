<?php

$idstatus = $_GET['t'];
$idProfile = $_GET['p'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/indexCompany.html');
$translate = (new \App\Model\Translate());
$else = '';
	
$users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
if (!empty($users)) {
    foreach ($users as $user) {
        $user = (new App\Model\User)->fetch($user->user);
        if ($idstatus == 100  ) {
			if($idProfile == 0){
				$else = 1;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$profiles = (new App\Model\Profile)->fetch($user->getProfile());
				if($profiles){
					if( $profiles->getId() == $user->getProfile() ){
						$tpl->PROFILE = $profiles->getName();						
					}
				}	
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');
			}elseif($idProfile != 0){
				if( $idProfile == $user->getProfile()  ){
					$else = 1;
					$status = \Cosmos\System\Helper::getStatus($user->getStatus());
					$user->setStatus($status->status);
					$tpl->status_class = $status->alert;
					$tpl->USER = $user;
					//perfil
					$profiles = (new App\Model\Profile)->fetch($user->getProfile());
					if($profiles){
						if( $profiles->getId() == $user->getProfile()  ){
							$tpl->PROFILE = $profiles->getName();						
						}
					}	
					if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
						$tpl->block('BLOCK_BTN_EDIT');
					}
					$tpl->block('BLOCK_USER');
				}
			}				
        } elseif ($user->getStatus() == $idstatus) {
			if($idProfile == 0){
				$else = 2;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$profiles = (new App\Model\Profile)->fetch($user->getProfile());
				if($profiles){
					if( $profiles->getId() == $user->getProfile()  ){
						$tpl->PROFILE = $profiles->getName();						
					}
				}
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');
			}elseif	($idProfile != 0){
				if( $idProfile == $user->getProfile()  ){
				$else = 2;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$profiles = (new App\Model\Profile)->fetch($user->getProfile());
				if($profiles){
					if( $profiles->getId() == $user->getProfile()  ){
						$tpl->PROFILE = $profiles->getName();						
					}
				}
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');
				}		
			}
		}	
    }
    $tpl->block('BLOCK_USERS');
} if (empty($else)) {
    $tpl->block('BLOCK_NO_USERS');
}
$st = array(100, 0, 1, 2);
foreach ($st as $s) {
    $status2 = \Cosmos\System\Helper::getStatus($s);
    foreach ($status2 as $sta => $value) {
        if ($sta === 'status') {
			if( $idstatus == $s ){
				$tpl->SELECTED = 'selected';
			}else{
				$tpl->SELECTED = '';
			}
            $tpl->VALUEST = $s;
            $tpl->TEXTST = $value;
            $tpl->block('BLOCK_STATUS');
        }
    }
}

$profiles = (new App\Model\Profile)->listing(\App\Model\Company::getCompany());
	if($profiles){
		foreach($profiles as $profile){	
			$tpl->IDPROFILE = $profile->getId();
			$tpl->PROFILE2 = $profile->getName();
			if( $idProfile == $tpl->IDPROFILE ){
				$tpl->SELECTED3 = 'selected';
			}elseif( $idProfile == 0 ){
				$tpl->SELECTED4 = 'selected';
			}else{
				$tpl->SELECTED3 = '';
			}
			
			$tpl->block('BLOCK_PROFILE');
		}	
	}
$tpl->show();
