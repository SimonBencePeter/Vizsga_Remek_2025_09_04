<?php


class CompanyController extends BaseController {
    public function index() {
        $companies = Company::getAll();

        $this->render("companies/index", [
            "companies" => $companies
        ]);
    }

    public function createForm() {
        $this->render("companies/create");
    }

  public function create() {
    $data = [
        'name'           => $_POST['name'] ?? '',
        'city'           => $_POST['city'] ?? '',
        'address'        => $_POST['address'] ?? '',
        'contact_person' => $_POST['contact_person'] ?? '',
        'contact_email'  => $_POST['contact_email'] ?? '',
        'contact_phone'  => $_POST['contact_phone'] ?? ''
    ];
    $id = Company::create($data);

    $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
    Log::add($userId, 'create', 'company', $id, json_encode(['data' => $data], JSON_UNESCAPED_UNICODE));

    Router::redirect('/companies');
}


    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) Router::redirect('/companies');

        $company = Company::find($id);
        $this->render("companies/edit", ['company' => $company]);
    }

    
public function update() {
    $id = (int)($_POST['id'] ?? 0);
    $old = Company::find($id) ?? [];

    $data = [
        'name'           => $_POST['name'] ?? '',
        'city'           => $_POST['city'] ?? '',
        'address'        => $_POST['address'] ?? '',
        'contact_person' => $_POST['contact_person'] ?? '',
        'contact_email'  => $_POST['contact_email'] ?? '',
        'contact_phone'  => $_POST['contact_phone'] ?? ''
    ];
    Company::update($id, $data);

    $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
    $changes = Audit::diff($old, array_merge($old, $data), ['id','created_at','updated_at']);
    if (!empty($changes)) {
        Log::addDiff($userId, 'update', 'company', $id, $changes);
    }

    Router::redirect('/companies');
}


    public function delete() {
    $id = (int)($_GET['id'] ?? 0);
    $old = Company::find($id) ?? [];
    Company::delete($id);

    $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
    Log::add($userId, 'delete', 'company', $id, json_encode(['name'=>$old['name'] ?? null], JSON_UNESCAPED_UNICODE));

    Router::redirect('/companies');
}
}
