<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'public/header.html');
$breadcrumb = explode("/", $_SERVER['REQUEST_URI']);
$first = array_shift($breadcrumb);
$title = $breadcrumb[0];
if ($breadcrumb[0] == '') {
    $title = 'Welcome';
}

if (App\Model\User::getUserLoged()) {
    $type = (new \App\Model\UserType)->fetch(App\Model\User::getUserLoged()->getUser_type());
    if (in_array($type->getLevel(), Array(2,3))) {
        $parameters = [''];
        $user_license = App\Model\UserLicense::getLisence(App\Model\User::getUserLoged());
        $company = (new \App\Model\Company)->fetch($user_license->getCompany());
        $type->setName($company->getConfig()->getName());
    } elseif ($type->getLevel() == 1) {
        $type->setName('I CHOOSE SAFETY');
    }
    $tpl->PANEL_NAME = $type->getName();
} else {
    $tpl->clear('PANEL_NAME');
}

//notifications
if (App\Model\User::getUserLoged()) {
    $notifications = (new \App\Model\Notification)->listingNotificationsUser(\App\Model\User::getUserLoged());

    if (!empty($notifications)) {
        foreach ($notifications as $notification) {
            $notification = (new App\Model\Notification)->fetch($notification->getId());
            $notification->url = (\Cosmos\System\Helper::getNotificationUrl($notification->getType(), array($notification->getId())));
            $notification->setType(\Cosmos\System\Helper::getNotificationType($notification->getType()));
            $tpl->NOTIFICATION = $notification;
            $tpl->block('BLOCK_NOTIFICATION');
        }
    }
    else {
        $tpl->block('BLOCK_NO_NOTIFICATION');
    }
    $tpl->COUNT_NOTIFICATION = sizeof($notifications);
}

if (App\Model\User::getUserLoged()) {
    $menus = (new App\Model\Menu())->getMenus();
    if (!empty($menus)) {
        foreach ($menus as $menu) {
            $translate = (new \App\Model\Translate());
            $translate->setText_default($menu->getName());
            $menu->setName(mb_strtoupper($translate->getTextTranslate()->getText()));
            $page = (new \App\Model\Page())->fetch($menu->getPage());
            if (strtolower($_SERVER['REQUEST_URI']) == $page->getLink()) {
                $tpl->class_active = 'active';
            } else {
                $tpl->clear('class_active');
            }
            $tpl->PAGE = $page;
            $tpl->MENU = $menu;
            $tpl->block('BLOCK_MENU');
        }
        $tpl->block('BLOCK_MENUS');
    }
    $tpl->USER = App\Model\User::getUserLoged();
} else {
    $translate = (new \App\Model\Translate());
    $menu = new App\Model\Menu;
    $menu->setIcon('icon-dashboard2');
    $menu->setName('Login');
    $translate->setText_default($menu->getName());
    $menu->setName(mb_strtoupper($translate->getTextTranslate()->getText()));
    $tpl->MENU = $menu;
    $tpl->block('BLOCK_MENU_PUBLIC');
}
$tpl->title = ucfirst($title);
if (isset($_SESSION['user_message']) && !is_null($_SESSION['user_message'])) {
    $tpl->MESSAGE = $_SESSION['user_message']['msg'];
    if ($_SESSION['user_message']['type'] == 1) {
        $tpl->TYPE_CLASS = 'success';
        $tpl->TYPE = 'Sucesso!';
    } else {
        $tpl->TYPE_CLASS = 'warning';
        $tpl->TYPE = 'Erro!';
    }
    Cosmos\System\Helper::my_session_start();
    $tpl->block("BLOCK_MESSAGE");
	
	if(session_status()== PHP_SESSION_NONE){	
		session_start();
	}
	$variable = $_SESSION['user_message'];
	unset( $_SESSION['user_message'], $variable );	
}
	

$translate = (new \App\Model\Translate());
$translate->setText_default("notifications");
$tpl->NOTIFICATIONTITLE = mb_strtoupper($translate->getTextTranslate()->getText());

$translate->setText_default("read all notifications");
$tpl->READALLNOTIFICATIONS = mb_strtoupper($translate->getTextTranslate()->getText());

$translate->setText_default("no notifications");
$tpl->NO_NOTIFICATIONS = mb_strtoupper($translate->getTextTranslate()->getText());

$tpl->show();
