<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/settings/index.html');

$parameters = [
    'deleted' => ['=', 0]
];
$factories = (new App\Model\Factory)->listingRegisters($parameters);
$sectors = (new App\Model\Sector)->listingRegisters($parameters);
$categories = (new App\Model\Category)->listingRegisters($parameters);
$profiles = (new App\Model\Profile)->listingRegisters($parameters);

$tpl->NUM_FACTORIES = count($factories);
$tpl->NUM_SECTORS = count($sectors);
$tpl->NUM_CATEGORIES = count($categories);
$tpl->NUM_PROFILES = count($profiles);

$tpl->show();