<?php
$idCompany = $_GET['c'];
$idProfile = $_GET['p'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/index.html');

$parameters = [
    'deleted' => ['=', 0, 'AND']
];
//**Profile 
if( $idProfile != 0 ){
	$parameters['profile'] = ['=', $idProfile, 'AND'];
}
$parameters['idUser'] = ['>', 0 , 'ORDER BY NAME' ];
$users2 = (new App\Model\User)->listingRegisters($parameters);
$data = array();
if( $users2 ){
	foreach ( $users2 as $us ){
		$data[] = $us->getId();
	}
}
$users = (new App\Model\User)->listingUsersCompany();
$dt = '';
$idt = '';
$it = '';
if ( !empty( $users ) ) {
    foreach ( $users as $user ) {
		$idCompany2 = $user->idCompany;
		if ( $idCompany == 0 ){
			if( $idProfile == 0  ){
				$it = 1;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$company = (new \App\Model\Company)->fetch($idCompany2);
				$profiles = (new App\Model\Profile)->listing($company);
				$dt = array();
				$idt = array();
				if($profiles){
					foreach($profiles as $profile){						 
						if( $user->getProfile() == $profile->getId() ){
							$tpl->PROFILE = $profile->getName();
						}
						$dt[] = $profile->getName();
						$idt[] = $profile->getId();
					}
				}
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');
				
			}elseif( in_array( $user->getId() , $data ) ){
				$it = 1;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$company = (new \App\Model\Company)->fetch($idCompany2);
				$profiles = (new App\Model\Profile)->listing($company);
				$dt = array();
				$idt = array();
				if($profiles){
					foreach($profiles as $profile){
						if( $profile->getId() == $user->getProfile() ){
							$tpl->PROFILE = $profile->getName();						
						}
						$dt[] = $profile->getName();
						$idt[] = $profile->getId();
					}	
				}
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');	
			}
		}elseif( $idCompany == $idCompany2 ){
			if( $idProfile == 0  ){
				$it = 1;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$company = (new \App\Model\Company)->fetch($idCompany2);
				$profiles = (new App\Model\Profile)->listing($company);
				$dt = array();
				$idt = array();
				if($profiles){
					foreach($profiles as $profile){						 
						if( $user->getProfile() == $profile->getId() ){
							$tpl->PROFILE = $profile->getName();
						}
						$dt[] = $profile->getName();
						$idt[] = $profile->getId();
					}
				}
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');
				
			}elseif( in_array( $user->getId() , $data ) ){
				$it = 1;
				$status = \Cosmos\System\Helper::getStatus($user->getStatus());
				$user->setStatus($status->status);
				$tpl->status_class = $status->alert;
				$tpl->USER = $user;
				//perfil
				$company = (new \App\Model\Company)->fetch($idCompany2);
				$profiles = (new App\Model\Profile)->listing($company);
				$dt = array();
				$idt = array();
				if($profiles){
					foreach($profiles as $profile){
						if( $profile->getId() == $user->getProfile() ){
							$tpl->PROFILE = $profile->getName();						
						}
						$dt[] = $profile->getName();
						$idt[] = $profile->getId();
					}	
				}
				if ($user->getId() !== \App\Model\User::getUserLoged()->getId()) {
					$tpl->block('BLOCK_BTN_EDIT');
				}
				$tpl->block('BLOCK_USER');	
			}
		}	
	}
	if(empty($it) && $it != 1){
		if( empty($dt) && empty($idt) ){
			$parameters = [
				'deleted' => ['=', 0]
			];
			$companys = (new App\Model\Company)->listingRegisters($parameters);
			if($companys){
				foreach($companys as $company){
					$profiles = (new App\Model\Profile)->listing($company);
					$dt = array();
					$idt = array();
					if($profiles){
						foreach($profiles as $profile){
							if( $profile->getId() == $user->getProfile() ){
								$tpl->PROFILE = $profile->getName();						
							}
							$dt[] = $profile->getName();
							$idt[] = $profile->getId();
						}	
					}
				}
			}					
			$dt2 = array_unique($dt);
			$dt3 = array_unique($idt);
			$tamanio = count($dt2);
			for ($x=0;$x<$tamanio; $x++){
				$tpl->IDPROFILE = $dt3[$x];
				$tpl->PROFILE2 = $dt2[$x];
				
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
		$tpl->block('BLOCK_NO_USERS');
		
		
		
	}elseif( !empty($dt) && !empty($idt) ){
		$dt2 = array_unique($dt);
		$dt3 = array_unique($idt);
		$tamanio = count($dt2);
		for ($x=0;$x<$tamanio; $x++){
			$tpl->IDPROFILE = $dt3[$x];
			$tpl->PROFILE2 = $dt2[$x];
			
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
}else {
	$tpl->block('BLOCK_NO_USERS');
}

$parameters = [
    'deleted' => ['=', 0]
];
$companys = (new \App\Model\Company)->listingRegisters($parameters);
if($companys){
	foreach($companys as $company){
		if( $idCompany == $company->getId() ){
			$tpl->SELECTED = 'selected';
		}elseif( $idCompany == 0 ){
			$tpl->SELECTED2 = 'selected';
		}else{
			$tpl->SELECTED = '';
		}
		$tpl->IdCompany = $company->getId();
		$tpl->COMPANY_NAME = $company->getConfig()->getName();
		$tpl->block('BLOCK_COMPANY');
	}
}

$tpl->show();
