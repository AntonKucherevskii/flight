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

    public static function add($url, $route)
    {
        self::$routes[$url] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    public static function matchRoute($query)
    {
        foreach (self::$routes as $k => $r)
        {
            if($query==$k)
            {
                self::$route = $r;
                return true;
            }

            return false;
        }
    }


}