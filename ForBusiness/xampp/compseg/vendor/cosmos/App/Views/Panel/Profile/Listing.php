<?php

$company_id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/profiles/listing.html');
$company = (new \App\Model\Company)->fetch($company_id);
$profiles = (new \App\Model\Profile())->listing($company);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
        $tpl->VALUE = $profile->getId();
        $tpl->TEXT = $profile->getName();
        $tpl->block('BLOCK_PROFILE');
    }
}
$tpl->show();
