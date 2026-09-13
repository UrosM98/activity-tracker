<?php

use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\ReportController;
use App\Controllers\StatController;
use App\Core\Request;
use App\Core\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

$router = new Router();

$router->get('/', AuthController::class, 'showLogin');
$router->get('/login', AuthController::class, 'showLogin');
$router->post('/login', AuthController::class, 'login');
$router->get('/register', AuthController::class, 'showRegister');
$router->post('/register', AuthController::class, 'register');
$router->post('/logout', AuthController::class, 'logout');

$router->get('/page-a', PageController::class, 'pageA');
$router->post('/buyCow', PageController::class, 'buy');
$router->get('/page-b', PageController::class, 'pageB');
$router->post('/download', PageController::class, 'download');

$router->get('/stat', StatController::class, 'statView');
$router->get('/reports', ReportController::class, 'reportsView');

$router->dispatch(new Request());