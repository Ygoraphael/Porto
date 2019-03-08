<?php

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;



$tpl = new Template(APP_PATH_TPL . 'panel/users/EditUser.html');


$user2 = (App\Model\User::getUserLoged()->getUser_type() );

if ($user2 == 1) {
	
	$user = (new \App\Model\User)->fetch($id);
	$level = (new App\Model\UserType)->fetch(App\Model\User::getUserLoged()->getUser_type())->getLevel();
	$parameters = [
		'level' => ['>=', $level, 'ORDER BY level DESC']
	];
	$level_types = (new App\Model\UserType())->listingRegisters($parameters);

	if (!empty($level_types)) {
		foreach ($level_types as $level) {
			if ($user->getUser_type() == $level->getId()) {
				$tpl->select = 'SELECTED';
				$user_type = $level;
			} else {
				$tpl->clear('select');
			}
			$tpl->TEXT = $level->getName();
			$tpl->VALUE = $level->getId();
			$tpl->block('BLOCK_SELECT_LEVEL');
		}
	}
	$company_id = $user->verifyCompanyById($user->getId())->getCompany();
	$companyf = (new \App\Model\Company())->fetch($company_id);
	$factorys = (new \App\Model\Factory)->listing($companyf );
	if (!empty($factorys)) {
		foreach ($factorys as $factory) {
			if ($user->getFactory() == $factory->getId()) {
				$tpl->SELECTED = 'selected';
			} else {
				$tpl->SELECTED = '';
			}
			$tpl->IDFACTORY = $factory->getId();
			$tpl->FACTORY = $factory->getName();
			$tpl->block('BLOCK_FACTORY');
		}
	}

	$parameters = [
		'user' => ['=', $user->getId()]
	];
	$user_permissions = [];
	$permissions = (new \App\Model\Permission)->getPermissionsUser($user);
	if (!empty($permissions)) {
		foreach ($permissions as $permission) {
			$user_permissions[] = $permission->getPage();
		}
	}
	$parameters = [
		'level_min' => ['<=', $user_type->getLevel(), 'AND'],
		'level_max' => ['>=', $user_type->getLevel(), 'AND'],
		'status' => ['=', 1]
	];
	$pages = (new App\Model\Page)->listingRegisters($parameters);
	if (!empty($pages)) {
		foreach ($pages as $page) {
			$translate = (new \App\Model\Translate());
			$translate->setText_default($page->getTitle());
			$page->setTitle(ucfirst($translate->getTextTranslate()->getText()));
			if (in_array($page->getId(), $user_permissions)) {
				$tpl->permission_true = 'checked';
				$tpl->clear('permission_false');
			} else {
				$tpl->permission_false = 'checked';
				$tpl->clear('permission_true');
			}
			$tpl->PAGE_MAIN = $page;
			$tpl->block('BLOCK_MENU_PERMISSION');
		}
		$tpl->block('BLOCK_PEMISSIONS');
	}

	//perfil
	$profiles = (new App\Model\Profile)->listing($companyf );
		if($profiles){
			foreach($profiles as $profile){	
				$tpl->IDPROFILE = $profile->getId();
				$tpl->PROFILE2 = $profile->getName();
				if( $user->getProfile() == $tpl->IDPROFILE ){
					$tpl->SELECTED3 = 'selected';
				}else{
					$tpl->SELECTED3 = '';
				}
				
				$tpl->block('BLOCK_PROFILE');
			}	
		}

	 
	$company_id = $user->verifyCompanyById($user->getId())->getCompany();
	$company = (new \App\Model\Company)->fetch($company_id);
	$tpl->IDCOMPANY = $company_id;
	$tpl->COMPANY = $company->getConfig()->getName();
	$tpl->block('BLOCK_COMPANY');

	$tpl->code = $user->getCode();
	$tpl->action = 'btn_save_edit';
	$tpl->USER = $user;
	$tpl->IDUSER = $user->getId();
	$tpl->TITLE = '%%Edit User%%';
	$tpl->show();
	
}elseif ($user2 == 2 || $user2 == 3){
	
	$user = (new \App\Model\User)->fetch($id);
	$level = (new App\Model\UserType)->fetch(App\Model\User::getUserLoged()->getUser_type())->getLevel();
	$parameters = [
		'level' => ['>=', $level, 'ORDER BY level DESC']
	];
	$level_types = (new App\Model\UserType())->listingRegisters($parameters);

	if (!empty($level_types)) {
		foreach ($level_types as $level) {
			if ($user->getUser_type() == $level->getId()) {
				$tpl->select = 'SELECTED';
				$user_type = $level;
			} else {
				$tpl->clear('select');
			}
			$tpl->TEXT = $level->getName();
			$tpl->VALUE = $level->getId();
			$tpl->block('BLOCK_SELECT_LEVEL');
		}
	}

	$factorys = (new \App\Model\Factory)->listing(\App\Model\Company::getCompany());
	if (!empty($factorys)) {
		foreach ($factorys as $factory) {
			if ($user->getFactory() == $factory->getId()) {
				$tpl->SELECTED = 'selected';
			} else {
				$tpl->SELECTED = '';
			}
			$tpl->IDFACTORY = $factory->getId();
			$tpl->FACTORY = $factory->getName();
			$tpl->block('BLOCK_FACTORY');
		}
	}

	$parameters = [
		'user' => ['=', $user->getId()]
	];
	$user_permissions = [];
	$permissions = (new \App\Model\Permission)->getPermissionsUser($user);
	if (!empty($permissions)) {
		foreach ($permissions as $permission) {
			$user_permissions[] = $permission->getPage();
		}
	}
	$parameters = [
		'level_min' => ['<=', $user_type->getLevel(), 'AND'],
		'level_max' => ['>=', $user_type->getLevel(), 'AND'],
		'status' => ['=', 1]
	];
	$pages = (new App\Model\Page)->listingRegisters($parameters);
	if (!empty($pages)) {
		foreach ($pages as $page) {
			$translate = (new \App\Model\Translate());
			$translate->setText_default($page->getTitle());
			$page->setTitle(ucfirst($translate->getTextTranslate()->getText()));
			if (in_array($page->getId(), $user_permissions)) {
				$tpl->permission_true = 'checked';
				$tpl->clear('permission_false');
			} else {
				$tpl->permission_false = 'checked';
				$tpl->clear('permission_true');
			}
			$tpl->PAGE_MAIN = $page;
			$tpl->block('BLOCK_MENU_PERMISSION');
		}
		$tpl->block('BLOCK_PEMISSIONS');
	}

	//perfil
	$profiles = (new App\Model\Profile)->listing(\App\Model\Company::getCompany());
		if($profiles){
			foreach($profiles as $profile){	
				$tpl->IDPROFILE = $profile->getId();
				$tpl->PROFILE2 = $profile->getName();
				if( $user->getProfile() == $tpl->IDPROFILE ){
					$tpl->SELECTED3 = 'selected';
				}else{
					$tpl->SELECTED3 = '';
				}
				
				$tpl->block('BLOCK_PROFILE');
			}	
		}

	 
	$company_id = $user->verifyCompanyById($user->getId())->getCompany();
	$company = (new \App\Model\Company)->fetch($company_id);
	$tpl->IDCOMPANY = $company_id;
	$tpl->COMPANY = $company->getConfig()->getName();
	$tpl->block('BLOCK_COMPANY');

	$tpl->code = $user->getCode();
	$tpl->action = 'btn_save_edit';
	$tpl->USER = $user;
	$tpl->IDUSER = $user->getId();
	$tpl->TITLE = '%%Edit User%%';
	$tpl->show();
	
} 	
