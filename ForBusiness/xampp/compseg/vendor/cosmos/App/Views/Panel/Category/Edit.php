<?php

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$category = (new \App\Model\Category)->fetch($id);
$tpl = new Template(APP_PATH_TPL . 'panel/categories/form_category.html');
$tpl->TITLE = '%%Edit Category%%';
$tpl->action = 'btn_save_edit';
$tpl->CATEGORY = $category;
$tpl->show();
