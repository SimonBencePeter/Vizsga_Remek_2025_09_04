<?php
class DeviceController extends BaseController {
    public function index() {
       
        $filters = [
            'company_id'    => $_GET['company_id']    ?? '',
            'device_name'   => $_GET['device_name']   ?? '',
            'serial_number' => $_GET['serial_number'] ?? '',
            'device_type'   => $_GET['device_type']   ?? '',
            'status'        => $_GET['status']        ?? '',
            'is_invoiced'   => $_GET['is_invoiced']   ?? '' // '', '0', '1'
        ];

        $perPage = 20;
        $pageNum = max(1, (int)($_GET['p'] ?? 1));
        $offset  = ($pageNum - 1) * $perPage;

        $devices   = Device::search($filters, $perPage, $offset);
        $total     = Device::count($filters);
        $pages     = (int)ceil(max(1, $total) / $perPage);

        $companies = Company::getAll();

        $qs = array_filter([
            'page'          => '/devices',
            'company_id'    => $filters['company_id'],
            'device_name'   => $filters['device_name'],
            'serial_number' => $filters['serial_number'],
            'device_type'   => $filters['device_type'],
            'status'        => $filters['status'],
            'is_invoiced'   => $filters['is_invoiced'],
        ], fn($v) => $v !== '' && $v !== null);
        $baseQS = http_build_query($qs);

        $this->render("devices/index", [
            "devices"   => $devices,
            "companies" => $companies,
            "filters"   => $filters,
            "pageNum"   => $pageNum,
            "pages"     => $pages,
            "total"     => $total,
            "baseQS"    => $baseQS
        ]);
    }

    public function create() {
    $data = [
        'device_name'   => $_POST['device_name'],
        'device_type'   => $_POST['device_type'],
        'serial_number' => $_POST['serial_number'],
        'company_id'    => $_POST['company_id'] ?: null,
        'status'        => $_POST['status'],
        'is_invoiced'   => isset($_POST['is_invoiced']) ? 1 : 0,
        'description'   => $_POST['description'] ?? null,
    ];
    $id = Device::create($data);

    $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
    Log::add($userId, 'create', 'device', $id, json_encode(['data'=>$data], JSON_UNESCAPED_UNICODE));

    Router::redirect('/devices');
}

    public function update() {
    $id  = (int)($_GET['id'] ?? 0);
    $old = Device::find($id) ?? [];

    $old['is_invoiced'] = isset($old['is_invoiced']) ? (int)$old['is_invoiced'] : 0;

    $data = [
        'device_name'   => $_POST['device_name']   ?? '',
        'device_type'   => $_POST['device_type']   ?? '',
        'serial_number' => $_POST['serial_number'] ?? '',
        'company_id'    => ($_POST['company_id'] ?? '') !== '' ? (int)$_POST['company_id'] : null,
        'status'        => $_POST['status']        ?? '',
        'is_invoiced'   => isset($_POST['is_invoiced']) ? 1 : 0,
        'description'   => $_POST['description']   ?? null,
    ];

    Device::update($id, $data);

    $userId  = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
    $changes = Audit::diff($old, $data, ['id','created_at','updated_at','company_name']);

    if (!empty($changes)) {
       
        Log::addDiff($userId, 'update', 'device', $id, $changes);
    }

    Router::redirect('/devices');
}


    public function delete() {
    $id = (int)($_GET['id'] ?? 0);
    $old = Device::find($id) ?? [];
    Device::delete($id);

    $userId = Session::getCurrentUser()['id'] ?? ($_SESSION['user_id'] ?? null);
    Log::add($userId, 'delete', 'device', $id, json_encode(['device_name'=>$old['device_name'] ?? null], JSON_UNESCAPED_UNICODE));

    Router::redirect('/devices');
}
}