<?php

$query = $_SERVER['QUERY_STRING'];
require_once (__DIR__.'/../vendor/libs/function.php');
require_once(__DIR__.'/../vendor/core/Router.php');

$r = new Router();
Router::addRoutes('/', ['controller' => 'main', 'action' => 'index']);
Router::showRoutes();