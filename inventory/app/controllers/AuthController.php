<?php
class AuthController extends BaseController {
    public function loginForm(): void {
        $title = "Bejelentkezés";
        include VIEW_PATH . '/auth/login.php';
    }

    public function doLogin(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
    $_SESSION['flash'][] = "Kérlek töltsd ki az összes mezőt!";
    Router::redirect('/login');
}
        $user = User::findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash'])) {
    $_SESSION['flash'][] = "Hibás felhasználónév vagy jelszó!";
    Router::redirect('/login');
}

        // Bejelentkeztetjük
        Session::login($user);
        Router::redirect('/');
    }

    public function logout(): void {
        Session::logout();
        Router::redirect('/login');
    }
}
