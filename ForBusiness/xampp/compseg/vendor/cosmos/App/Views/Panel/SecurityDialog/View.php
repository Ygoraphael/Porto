<?php

$id = $_GET['id'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/index.html');
$dialog = (new \App\Model\SecurityDialog)->fetch($id);
$tpl->DIALOG = $dialog;
$tpl->show();
