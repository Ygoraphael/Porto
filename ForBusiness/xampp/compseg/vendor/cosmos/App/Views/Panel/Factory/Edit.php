<?php

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$factory = (new \App\Model\Factory)->fetch($id);
$tpl = new Template(APP_PATH_TPL . 'panel/factorys/form_factory.html');
$tpl->TITLE = '%%Edit Factory%%';
$tpl->action = 'btn_save_edit';
$tpl->FACTORY = $factory;
$tpl->show();
