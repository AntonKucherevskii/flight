<?php
use vendor\core\Router;

$query = $_SERVER['QUERY_STRING'];

define('WWW', __DIR__);
define('CORE', dirname(__DIR__).'/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__).'/app');
define('LAYOUT', 'default');

require_once(__DIR__ . '/../vendor/libs/function.php');

// Автозагрузка классов
spl_autoload_register(function($class){
    $class = str_replace('\\', '/', $class);
    $file = ROOT.'/'.$class.'.php';
    if(is_file($file)){
        require_once $file;
    }
});

//Добавление маршрутов
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);

//Defaults routs
Router::add('^$', ['controller' => 'main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
//--------------------

Router::dispatch($query);



