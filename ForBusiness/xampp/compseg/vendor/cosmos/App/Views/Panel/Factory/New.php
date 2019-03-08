<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/factorys/form_factory.html');
$tpl->TITLE = '%%New Factory%%';
$tpl->action = 'btn_save';
$tpl->show();
