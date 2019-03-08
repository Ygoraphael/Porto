<?php

$ano = $_GET['ano'];

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/rules.html');

if (!$ano) {
    $ano = date('Y');
}

$parameters = [
    'deleted' => ['=', 0]
];
$dialogs = (new App\Model\SecurityDialog)->listingRegisters($parameters);

if (!empty($dialogs)) {
    foreach ($dialogs as $dialog) {
        $parameters = [
            'securitydialog' => ['=', $dialog->getId(), 'AND'],
            'year' => ['=', $ano]
        ];
        $securitydialogweek = (new \App\Model\SecurityDialogWeek)->listingRegisters($parameters);

        if (sizeof($securitydialogweek)) {
            $securitydialogweek = $securitydialogweek[0];
            $dialog->val = $securitydialogweek->getWeek();
        } else {
            $dialog->val = 0;
        }

        $tmp = '<select id="week" data-id="' . $dialog->getId() . '" name="dialog_' . $dialog->getId() . '" class="form-control week">';
        for ($i = 0; $i < 53; $i++) {
            if ($dialog->val == $i) {
                $select = 'SELECTED';
            } else {
                $select = '';
            }
            $tmp .= '<option value="'. $i .'" '. $select .'>'. $i .'</option>';
        }
        $tmp .= '</select>';
        
        $dialog->select = $tmp;
        
        $tpl->DIALOG = $dialog;
        $tpl->block('BLOCK_DIALOG');
    }
}
$tpl->DIALOG_YEAR = $ano;
$tpl->CURRENT_ANO = $ano;

$tpl->show();
