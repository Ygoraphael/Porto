<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/profiles/form_profile.html');
$tpl->TITLE = '%%New Profile%%';
$tpl->action = 'btn_save';
$tpl->show();
