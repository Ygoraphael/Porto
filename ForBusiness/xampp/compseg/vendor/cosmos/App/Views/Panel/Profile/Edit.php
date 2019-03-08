<?php

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$profile = (new \App\Model\Profile)->fetch($id);
$tpl = new Template(APP_PATH_TPL . 'panel/profiles/form_profile.html');

$parameters = [
    'deleted' => ['=', 0]
];
$monitors = (new App\Model\Monitor)->listingRegisters($parameters);

if (!empty($monitors)) {
    foreach ($monitors as $monitor) {

        $parameters = [
            'deleted' => ['=', 0, 'AND'],
            'status' => ['=', 1, 'AND'],
            'monitor' => ['=', $monitor->getId(), 'AND'],
            'profile' => ['=', $id]
        ];
        $profilemonitor = (new App\Model\ProfileMonitor)->listingRegisters($parameters);

        if( !empty($profilemonitor) ) {
            $tpl->permission_true = 'checked';
            $tpl->clear('permission_false');
        }
        else {
            $tpl->permission_false = 'checked';
            $tpl->clear('permission_true');
        }

        $tpl->MONITOR = $monitor;
        $tpl->block('BLOCK_MONITOR');
    }
    $tpl->block('BLOCK_MONITORS');
} else {
    $tpl->block('BLOCK_NO_MONITORS');
}

$tpl->TITLE = '%%Edit Profile%%';
$tpl->action = 'btn_save_edit';
$tpl->PROFILE = $profile;
$tpl->show();
