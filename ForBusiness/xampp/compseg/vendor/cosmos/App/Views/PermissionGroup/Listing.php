<?php

$level = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'permission_group/listing.html');
$parameters = [
    'level' => ['=', $level, 'AND'],
    'status' => ['=', 1]
];
$groups = (new App\Model\PermissionGroup)->listingRegisters($parameters);
if (!empty($groups)) {
    foreach ($groups as $group) {
        $tpl->GROUP = $group;
        $tpl->block('BLOCK_GROUP_PERMISSION');
    }
    $tpl->block('BLOCK_GROUP_PERMISSIONS');
}
$tpl->show();
