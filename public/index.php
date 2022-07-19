<?php
declare(strict_types=1);

use App\App;
use App\Config;
use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');

$router = new Router();
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->run();