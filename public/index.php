<?php

$query = $_SERVER['QUERY_STRING'];
require_once(__DIR__ . '/../vendor/libs/function.php');
require_once(__DIR__ . '/../vendor/core/Router.php');


Router::add('', ['controller' => 'main', 'action' => 'index']);


if (Router::matchRoute($query)) {
    debug(Router::getRoute());
} else {
    print '404';
}