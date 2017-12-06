<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 9:59
 */
require_once '../Loader.php';
$requestPath = $_SERVER['REQUEST_URI'];
$path = explode('/', trim($requestPath, '/'));
$className = ucfirst($path[0]);
$params = [];
if (isset($path[1])) {
    $params = array_shift($path);
}

if (strpos($className, 'api') === false) {
    $method = 'show';
} else {
    $tmp = explode('_', $className);
    $className = $tmp[0];
    $method = 'api';
}

$file = '../app/controller/' . $className . '.class.php';
if (file_exists($file)) {
    require_once $file;
} else {
    require_once '../app/controller/' . 'Home.class.php';
    $className = 'Home';
}

$class = new $className();
$class->run($method, $params);

