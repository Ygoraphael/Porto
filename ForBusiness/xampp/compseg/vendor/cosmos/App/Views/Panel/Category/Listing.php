<?php

$company_id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/categories/listing.html');
$company = (new \App\Model\Company)->fetch($company_id);
$categories = (new \App\Model\Category())->listing($company);
if (!empty($categories)) {
    foreach ($categories as $category) {
        $tpl->VALUE = $category->getId();
        $tpl->TEXT = $category->getName();
        $tpl->block('BLOCK_CATEGORY');
    }
}
$tpl->show();
