<?php

include_once 'botstrap.php';

use Cosmos\System\Router;
use Cosmos\System\Request;
use Cosmos\System\ErrorController;

try {
    Router::route(new Request);
} catch (Exception $e) {
    $controller = new ErrorController;
    $controller->error($e->getMessage());
}