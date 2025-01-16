<?php
require dirname(__FILE__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';
// include '../config.php';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/blog':
        require __DIR__ . $viewDir . 'blog.php';
        break;
    case '/version':
        require __DIR__ . $viewDir . 'version.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
