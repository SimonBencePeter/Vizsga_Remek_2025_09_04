<?php

class Router
{
    /** @var array<string, array<string, array{0:string,1:string}>> */
    private array $routes = [
        'GET'  => [],
        'POST' => [],
    ];

    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$this->normalize($path)] = [$controller, $action];
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$this->normalize($path)] = [$controller, $action];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path   = $this->normalize($_GET['page'] ?? '/');

        if (!isset($this->routes[$method][$path])) {
            $this->show404("Nincs route: {$method} {$path}");
            return;
        }

        [$controllerName, $action] = $this->routes[$method][$path];

        $ctrlDir = defined('CTRL_PATH') ? CTRL_PATH : (APP_PATH . '/controllers');
        $file    = rtrim($ctrlDir, '/\\') . '/' . $controllerName . '.php';

        if (!is_file($file)) {
            $this->show404("Controller fájl hiányzik: {$controllerName}");
            return;
        }
        require_once $file;

        if (!class_exists($controllerName)) {
            $this->show404("Controller osztály hiányzik: {$controllerName}");
            return;
        }

        $controller = new $controllerName();

        if (!is_callable([$controller, $action])) {
            $this->show404("Nincs ilyen action: {$controllerName}::{$action}()");
            return;
        }

        $controller->$action();
    }

   
    private function normalize(string $path): string
    {
        $p = parse_url($path, PHP_URL_PATH) ?? '/';
        $p = '/' . ltrim(trim($p), '/');
       
        return $p === '' ? '/' : $p;
    }

    
    private function show404(string $internalMsg = ''): void
    {
        http_response_code(404);

        $view404 = (defined('VIEW_PATH') ? VIEW_PATH : (APP_PATH . '/views')) . '/error/404.php';
        $debug   = defined('DEBUG') ? DEBUG : false;

        if (is_file($view404)) {
        
            $error_message = $debug ? $internalMsg : '';
            include $view404;
            return;
        }

    
        echo "<!doctype html><html lang='hu'><head><meta charset='utf-8'><title>404 - Oldal nem található</title></head><body>";
        echo "<h1>404 - Oldal nem található</h1>";
        if ($debug && $internalMsg) {
            echo "<p><small>" . htmlspecialchars($internalMsg, ENT_QUOTES, 'UTF-8') . "</small></p>";
        }
        echo "<p><a href='?page=/'>Főoldal</a></p>";
        echo "</body></html>";
    }


    public static function redirect(string $path): void
    {
        $p = '/' . ltrim($path, '/');
        header("Location: ?page={$p}");
        exit;
    }
}
