<?php
class DashboardController extends BaseController {
    public function index(): void {
        
        if (!Session::user()) {
            Router::redirect('/login');
        }

        $user = Session::user();

        $this->render("dashboard", [
            "title" => "Dashboard",
            "user"  => $user
        ]);
    }
}
