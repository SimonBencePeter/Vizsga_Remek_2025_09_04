<?php

class UserController extends BaseController {
    
    public function index(): void {
        if (!Session::isAdmin()) {
            Router::redirect('/');
        }
        $users = User::all();

        $this->render("users/index", [
            "users" => $users,
            "title" => "Felhasználók"
        ]);
    }

    public function createForm(): void {
        if (!Session::isAdmin()) Router::redirect('/');
        
        $this->render("users/create", [
            "title" => "Új felhasználó létrehozása"
        ]);
    }

    public function create(): void {
        if (!Session::isAdmin()) Router::redirect('/');

        $newId = User::create($_POST);

        $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
        $safe = $_POST;
        unset($safe['password'], $safe['password_hash']);
        Log::add($userId, 'create', 'user', $newId, json_encode(['data'=>$safe], JSON_UNESCAPED_UNICODE));

        Router::redirect('/users');
    }

    public function editForm(): void {
        if (!Session::isAdmin()) Router::redirect('/');
        $id = (int)($_GET['id'] ?? 0);
        $user = User::find($id);

        $this->render("users/edit", [
            "user" => $user,
            "title" => "Felhasználó szerkesztése"
        ]);
    }

    public function update(): void {
        if (!Session::isAdmin()) Router::redirect('/');
        $id  = (int)$_POST['id'];
        $old = User::find($id) ?? [];

        User::update($id, $_POST);

        $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
        $newForDiff = $old;
        foreach ($_POST as $k=>$v) { $newForDiff[$k] = $v; }

      
        $changes = Audit::diff(
            $old, 
            $newForDiff, 
            ['id','created_at','updated_at','password','password_hash'],
            ['password','password_hash']
        );
        if (!empty($changes)) {
            Log::addDiff($userId, 'update', 'user', $id, $changes);
        }

        Router::redirect('/users');
    }

    public function delete(): void {
        if (!Session::isAdmin()) Router::redirect('/');
        $id = (int)$_GET['id'];
        User::delete($id);
        Router::redirect('/users');
    }

    public function changePasswordForm(): void {
        if (!Session::isLoggedIn()) Router::redirect('/');

        $this->render("users/change_password", [
            "title" => "Jelszó módosítása"
        ]);
    }

    public function changePassword(): void {
        if (!Session::isLoggedIn()) Router::redirect('/');
        $id = Session::getCurrentUser()['id'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($new !== $confirm) {
            Session::setFlash('danger', "A két jelszó nem egyezik!");
            Router::redirect('/users/change-password');
        }

        User::updatePassword($id, $new);

        $userId = $id;
       
        Log::addDiff($userId, 'update', 'user', $id, [['field'=>'password','old'=>'[hidden]','new'=>'[hidden]']]);

        Session::setFlash('success', "Sikeresen megváltoztattad a jelszavad!");
        Router::redirect('/users/change-password');
    }
}