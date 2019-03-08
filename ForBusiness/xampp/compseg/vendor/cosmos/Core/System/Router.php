<?php

namespace Cosmos\System;

Class Router {

    private static function breadCrumb($link) {
        $links = explode("/", $link);
        $first = array_shift($links);
        return $links;
    }

    public function header() {
        $_GET['breadcrumb'] = self::breadCrumb($_SERVER['REQUEST_URI']);
        return require_once APP_PATH . 'vendor/cosmos/App/Includes/header.php';
    }

    public static function route(Request $request) {
        ob_start();
        $controller = "\\App\\Controller\\" . $request->getController();
        $method = $request->getMethod();
        $args = $request->getArgs();

        $controllerFile = APP_PATH . 'vendor/cosmos/App/Controller/' . ucfirst($request->getController()) . '.php';

        if (is_readable($controllerFile)) {
            require_once $controllerFile;

            $controller = new $controller;

            $method = (is_callable(array($controller, $method))) ? $method : 'error404';
            if (!empty($args)) {
                call_user_func_array(array($controller, $method), $args);
            } else {
                call_user_func(array($controller, $method));
            }
        } else {
            self::error404();
        }
        ob_end_flush();
    }

    public function footer() {
        return require_once APP_PATH . 'vendor/cosmos/App/Includes/footer.php';
    }

    private static function error404() {
        return require_once APP_PATH . 'vendor/cosmos/App/Views/Public/404.php';
    }

}