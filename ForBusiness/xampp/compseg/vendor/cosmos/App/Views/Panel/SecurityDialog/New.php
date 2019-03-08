<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/form_security_dialog.html');
$translate = (new \App\Model\Translate());
 /**BUTTONS DE AÇAO**/
 $tpl->TITLE = '%%New Dialogue%%';
$parameters = [
   'deleted' => ['=', 0, '']
];

$profiles = (new App\Model\Profile)->listingRegisters($parameters);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
		$PROFILE = (new \App\Model\Translate())->translater($profile->getName());
		$profile->setName($PROFILE);
        $tpl->SELECT_PROFILE = $profile;
        $tpl->block('BLOCK_SELECT_PROFILE');
    }
}

$tpl->show();
