<?php

class Session {

    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(array $user) {
        self::start();
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role']      = $user['role'];
    }

    public static function logout() {
        self::start();
        session_destroy();
    }

    public static function isLoggedIn(): bool {
        self::start();
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin(): bool {
        self::start();
        return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
    }

    public static function getCurrentUser(): ?array {
        self::start();
        if (!self::isLoggedIn()) {
            return null;
        }
        return [
            'id'        => $_SESSION['user_id'],
            'username'  => $_SESSION['username'],
            'full_name' => $_SESSION['full_name'],
            'role'      => $_SESSION['role']
        ];
    }

    
    public static function user(): ?array {
        return self::getCurrentUser();
    }

    public static function setFlash(string $type, string $message) {
        self::start();
        $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
    }

    public static function getFlashes(): array {
        self::start();
        $flashes = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flashes;
    }
}
