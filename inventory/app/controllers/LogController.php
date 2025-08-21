<?php

class LogController extends BaseController {
    
    public function index() {
        if (!Session::isAdmin()) {
            $this->render('/dashboard');
            return;
        }

        $perPage = 20;
        $maxRows = 200;
        
        $page = max(1, (int)($_GET['p'] ?? 1));
        
        $row = Database::fetch("SELECT COUNT(*) AS c FROM logs");
        $all  = (int)($row['c'] ?? 0);
        $total = min($all, $maxRows);
        $pages = max(1, (int)ceil($total / $perPage));
        
        if ($page > $pages) $page = $pages;

        $offset = ($page - 1) * $perPage;

        $limitSql  = (int)$perPage;
        $offsetSql = (int)$offset;

        $logs = Database::fetchAll("
            SELECT l.*, u.username, u.full_name
            FROM logs l
            LEFT JOIN users u ON l.user_id = u.id
            ORDER BY l.created_at DESC
            LIMIT {$limitSql} OFFSET {$offsetSql}
        ");

        // Helper függvények a view-hoz
        $helpers = [
            'h' => fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'),
            'yn' => fn($v) => ((string)$v === '1' || $v === 1 || $v === true) ? 'Igen' : 'Nem',
            'wrapText' => fn($text, $length = 30) => wordwrap($text, $length, "<br>", true),
            'label' => [
                'device_name'   => 'Eszköz neve',
                'device_type'   => 'Típus',
                'serial_number' => 'Sorozatszám',
                'company_id'    => 'Cég azonosító',
                'status'        => 'Státusz',
                'is_invoiced'   => 'Számlázva',
                'description'   => 'Leírás',
                'name'          => 'Név',
                'city'          => 'Város',
                'address'       => 'Cím',
                'contact_person' => 'Kapcsolattartó',
                'contact_email'  => 'Email',
                'contact_phone'  => 'Telefon',
            ],
            'renderChange' => function(array $chg, array $labelMap, callable $h, callable $yn, callable $wrapText) {
                $field  = $chg['field']  ?? '';
                $old    = $chg['old']    ?? '';
                $new    = $chg['new']    ?? '';
                $nice   = $labelMap[$field] ?? $field;

                if ($field === 'is_invoiced') {
                    $old = $yn($old);
                    $new = $yn($new);
                }
                
                // Szöveg tördelése 30 karakter után
                $oldWrapped = $wrapText($h($old));
                $newWrapped = $wrapText($h($new));
                
                return "<ul><strong>{$h($nice)}:</strong> <em>{$oldWrapped}</em> → <em>{$newWrapped}</em></ul>";
            }
        ];

        $this->render('logs/index', [
            'logs'    => $logs,
            'page'    => $page,
            'pages'   => $pages,
            'total'   => $total,
            'helpers' => $helpers
        ]);
    }
}