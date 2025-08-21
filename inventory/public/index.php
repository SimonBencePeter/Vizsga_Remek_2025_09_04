<?php
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH',  BASE_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('DEBUG', false); 

require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Session.php';

spl_autoload_register(function($class){
  foreach (['controllers','models','core'] as $d) {
    $f = APP_PATH . "/$d/$class.php";
    if (is_file($f)) { require_once $f; return; }
  }
});

set_error_handler(function($severity, $message, $file, $line){
  if (!(error_reporting() & $severity)) return;
  throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function(Throwable $e){
  http_response_code(500);

  if (DEBUG) {
    echo "<h1>Hiba (DEBUG)</h1><pre>" . htmlspecialchars((string)$e, ENT_QUOTES, 'UTF-8') . "</pre>";
    return;
  }
  error_log("[APP] Uncaught: " . $e->getMessage());
  $view = VIEW_PATH . '/error/500.php';
  if (is_file($view)) { include $view; } else { echo "<h1>500 - Váratlan hiba</h1>"; }
});

Session::start();

$router = new Router();

$router->get('/', 'DashboardController', 'index');
$router->get('/login', 'AuthController', 'loginForm');
$router->post('/login', 'AuthController', 'doLogin');
$router->get('/logout', 'AuthController', 'logout');

$router->get('/devices', 'DeviceController', 'index');
$router->post('/devices/create', 'DeviceController', 'create');
$router->post('/devices/update', 'DeviceController', 'update');
$router->get('/devices/delete', 'DeviceController', 'delete');

$router->get('/companies', 'CompanyController', 'index');
$router->post('/companies/create', 'CompanyController', 'create');
$router->post('/companies/update', 'CompanyController', 'update');
$router->get('/companies/delete', 'CompanyController', 'delete');

$router->get('/users', 'UserController', 'index');
$router->get('/users/create', 'UserController', 'createForm');
$router->post('/users/create', 'UserController', 'create');
$router->get('/users/edit', 'UserController', 'editForm');
$router->post('/users/update', 'UserController', 'update');
$router->get('/users/delete', 'UserController', 'delete');
$router->get('/users/change-password', 'UserController', 'changePasswordForm');
$router->post('/users/change-password', 'UserController', 'changePassword');

$router->get('/logs', 'LogController', 'index');

$router->dispatch();
