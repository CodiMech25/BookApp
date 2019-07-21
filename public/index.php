<?php

require_once(__DIR__ . '/../src/autoload.php');

define('BASE_DIR', __DIR__ . '/../src/BookApp');
date_default_timezone_set('Europe/Prague');

$router = new \BookApp\Runtime\Router();
$router->addRoute('/', 'Overview');
$router->addRoute('/add-book', 'Overview', 'AddBook');
$router->addRoute('/remove-book', 'Overview', 'RemoveBook');

$app = new \BookApp\Runtime\Boot($router);
$app->start();
