<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/form_user.html');
$tpl->code = Cosmos\System\Helper::createCode();
$tpl->show();