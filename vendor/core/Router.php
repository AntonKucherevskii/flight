<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 18.01.2020
 * Time: 13:46
 */

class Router
{
    protected static $routes = [];
    protected static $route = [];

    public static function addRoutes($url, $route)
    {
        self::$routes[$url] = $route;
    }

    public static function showRoutes()
    {
        debug(self::$routes);
    }

    public static function getRoute($query)
    {
    }


}