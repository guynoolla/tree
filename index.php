<?php

function pr($a, $b="") {
    if ($a && $b) {
        echo "<pre>$a " . print_r($b, 1) . '</pre>';
    } else {
        echo '<pre>' . print_r($a, 1) . '</pre>';
    }
}

require ("./vendor/autoload.php");
require ("./src/functions.php");
$config = require ("./src/config.php");

if (version_compare(phpversion(), '8.1.0', '<')) {
    echo "Проект работает на PHP >= 8.1.0.";
}

$path =  parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if (substr($path, 0, strlen($config['url_base'])) == $config['url_base']) {
    $path = substr($path, strlen($config['url_base']));
}

$path = explode("/", rtrim($path, "/\\"));

if ($path[0] === 'admin') {
    if (count($path) == 1) {
        $file = 'Admin' . DIRECTORY_SEPARATOR . 'index.php';
    } elseif (count($path) == 2) {
        $file = 'Admin' . DIRECTORY_SEPARATOR . $path[1] . '.php';
    }
} else if ($path[0] === "") {
    $file = 'Page' . DIRECTORY_SEPARATOR . 'Home.php';
} else {
    $file = ucfirst($path[0]) . DIRECTORY_SEPARATOR . $path[1] . '.php';
}

$controllerDir = $config["app_root"] . DIRECTORY_SEPARATOR . 'Controller';
$file = $controllerDir . DIRECTORY_SEPARATOR . $file;
$db = Guynoolla\App\Core\Database::getInstance($config['db']);
$controller = new Guynoolla\App\Core\Controller($config, $db, $path);

if (!file_exists($file)) {
    header("Location: /400?r=" . $_SERVER["REQUEST_URI"]);
    exit;
}

session_start();

$controller->run($file, $path);
