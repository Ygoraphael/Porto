<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/categories/form_category.html');
$tpl->TITLE = '%%New Category%%';
$tpl->action = 'btn_save';
$tpl->show();
