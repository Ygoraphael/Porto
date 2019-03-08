<?php

$country = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'city/listing.html');
switch ($country) {
    case 0:
        $tpl->block('BLOCK_PORTUGAL');
        break;
    case 1:
        $tpl->block('BLOCK_ANGOLA');
        break;
    case 2:
        $tpl->block('BLOCK_BRASIL');
        break;
    default:
        break;
}
$tpl->show();
