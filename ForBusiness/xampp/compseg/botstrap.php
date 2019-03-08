<?php

declare(strict_types = 1);
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

require __DIR__ . '/vendor/autoload.php';
date_default_timezone_set('Europe/Lisbon');
header('Content-Type: text/html; charset=utf-8');
\Cosmos\System\Helper::my_session_start();
$_SESSION['lang'] = 'pt';
if (!isset($_SESSION['cur_lang'])) {
    $_SESSION['cur_lang'] = 'pt';
}
define('APP_SITE_URL', 'http://cseg.local');
define('APP_PATH', __DIR__ . '/');
define('APP_PATH_TPL', APP_PATH . 'html/templates/');
define('APP_PATH_VIEW', APP_PATH . 'vendor/App/Views/');
define('APP_SALT', 'C0mPs3-*');
//mail config
define('APP_EMAIL_HOST', "mail.ichoosesafety.com");
define('APP_EMAIL_SSL', true);
define('APP_EMAIL_USERNAME', "info@ichoosesafety.com"); // Usuário do servidorSMTP
define('APP_EMAIL_PASSWORD', "ics2777gh+-"); // Senha do servidor SMTP
define('APP_EMAIL_FROMNAME', "I Choose Safety"); //Usuário nome
define('APP_EMAIL_FROMEMAIL', "info@ichoosesafety.com");
//secury trafic config
define('APP_SECRET_TRAFIC', "x_D3KaZu+Afr");
