<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'public/index.html');

if (isset($_SESSION['msg']) && !is_null($_SESSION['msg'])) {
    $tpl->MESSAGE = $_SESSION['msg'];
    if ($_SESSION['tipo'] == 1) {
        $tpl->TYPE_CLASS = 'success';
        $tpl->TYPE = 'Sucesso!';
    } else {
        $tpl->TYPE_CLASS = 'warning';
        $tpl->TYPE = 'Erro!';
    }
    Cosmos\System\Helper::my_session_start();
    $tpl->block("BLOCK_MESSAGE");

    $variable = $_SESSION['msg'];
    unset($_SESSION['msg'], $variable);
}

if ($_SESSION['cur_lang'] == 'pt') {
    $tpl->block('BLOCK_BOTPT');
    $tpl->block('BLOCK_REMPT');
    $tpl->block('BLOCK_TEXTPT');
    $tpl->block('BLOCK_DEMOPT');
    $tpl->block('BLOCK_DEMOTOPPT');
    $tpl->block('BLOCK_FILEFORMPT');
} else if ($_SESSION['cur_lang'] == 'es') {
    $tpl->block('BLOCK_BOTES');
    $tpl->block('BLOCK_REMES');
    $tpl->block('BLOCK_TEXTES');
    $tpl->block('BLOCK_DEMOES');
    $tpl->block('BLOCK_DEMOTOPES');
    $tpl->block('BLOCK_FILEFORMES');
}

$tpl->show();
