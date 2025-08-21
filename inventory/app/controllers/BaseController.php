<?php
class BaseController {
    protected function render(string $view, array $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../views/{$view}.php";
        include __DIR__ . "/../views/layout.php";
    }
}
