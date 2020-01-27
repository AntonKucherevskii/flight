<?php
namespace vendor\core;

class Router
{
    protected static $routes = [];
    protected static $route = [];


    /**
     * Добавляет маршруты
     * @param $url Регулярное выражение соответствующее запросу
     * @param array $route Маршрут (controller, action)
     */
    public static function add($url, $route = [])
    {
        self::$routes[$url] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }


    /**
     * Задает текущий маршрут
     * @return array массив с (controller, action)
     */
    public static function getRoute()
    {
        return self::$route;
    }


    /**
     * Вычисляет текущий маршрут (controller, action) исходя из запроса
     * @param $query
     * @return bool
     */
    public static function matchRoute($query)
    {

        foreach (self::$routes as $k => $r) {
            if (preg_match("#$k#i", $query, $matches)) {

                foreach($matches as $m => $v)
                {
                    if (is_string($m)) {
                        $r[$m] = $v;
                    }
                }
                if(!isset($r['action'])) {
                    $r['action'] = 'index';
                }
                self::$route = $r;
                self::$route['controller'] = self::upperCamelCase(self::$route['controller']);
                return true;
            }
        }
        return false;
    }

    /**
     * перенаправляет по корректному маршруту
     * @param string $query входящая строка запроса
     * return void
     */
    public static function dispatch($query)
    {
        $query = self::removeQueryString($query);
        if (Router::matchRoute($query)) {
            $controller = 'app\\controller\\' . self::upperCamelCase(self::$route['controller']) . 'Controller';

            if(class_exists($controller)){
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']).'Action';
                if(method_exists($cObj, $action)){
                    $cObj->$action();
                    $cObj->getView();
                }else{
                    echo 'Метод: '.$action.' отсутствует';
                }
            }else{
                echo 'Контроллер: '.$controller.' отсутствует';
            }

        } else {
            http_response_code(404);
            include_once '404.html';
        }
    }

    /**
     * Приводит имена к виду 'NameController'
     * @param $name
     * @return mixed|string
     */
    protected static function upperCamelCase($name)
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }

    /**
     * Приводит имена к виду 'nameAction'
     * @param $name
     * @return mixed|string
     */
    protected static function lowerCamelCase($name)
    {
        $name = self::upperCamelCase($name);
        $name = lcfirst($name);
        return $name;
    }

    protected static function removeQueryString($url)
    {
        $params = explode('&', $url, 2);
        if(false===strpos($params[0], '='))
        {
            return rtrim($params[0], '/');
        }else{
            return '';
        }
        return $url;
    }
}