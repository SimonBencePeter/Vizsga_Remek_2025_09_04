<?php
$h = $helpers['h'];
$yn = $helpers['yn'];
$wrapText = $helpers['wrapText'];
$label = $helpers['label'];
$renderChange = $helpers['renderChange'];
?>

<div class="container py-4">
    <h2 class="text-center text-md-start">Rendszerlogok</h2>
    <p class="text-muted text-center text-md-start">Összes találat (max 200): <?= (int)$total ?> | Oldal <?= (int)$page ?>/<?= (int)$pages ?></p>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Felhasználó</th>
                    <th>Művelet</th>
                    <th>Entitás</th>
                    <th>Entitás ID</th>
                    <th>Részletek</th>
                    <th>Dátum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= (int)$log['id'] ?></td>
                        <td><?= $wrapText($h($log['full_name'] ?: $log['username'] ?: 'Ismeretlen')) ?></td>
                        <td><?= $wrapText($h($log['action'])) ?></td>
                        <td><?= $wrapText($h($log['entity'])) ?></td>
                        <td><?= (int)$log['entity_id'] ?></td>
                        <td>
                            <?php
                            $printed = false;
                            if (!empty($log['details'])) {
                                $details = json_decode($log['details'], true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($details)) {
                                    if (!empty($details['changes']) && is_array($details['changes'])) {
                                        echo '<ul class="mb-0">';
                                        foreach ($details['changes'] as $chg) {
                                            echo $renderChange($chg, $label, $h, $yn, $wrapText);
                                        }
                                        echo '</ul>';
                                        $printed = true;
                                    } elseif (!empty($details['data']) && is_array($details['data'])) {
                                        echo '<div class="small text-muted">Létrehozott adatok:</div>';
                                        echo '<ul class="mb-0">';
                                        foreach ($details['data'] as $k => $v) {
                                            $nice = $label[$k] ?? $k;
                                            if ($k === 'is_invoiced') $v = $yn($v);
                                            echo "<ul><strong>{$h($nice)}:</strong> {$wrapText($h($v))}</ul>";
                                        }
                                        echo '</ul>';
                                        $printed = true;
                                    } elseif (!empty($details['note'])) {
                                        echo $wrapText($h($details['note']));
                                        $printed = true;
                                    }
                                }
                            }
                            if (!$printed) {
                                echo '<span class="text-muted">–</span>';
                            }
                            ?>
                        </td>
                        <td><?= $wrapText($h($log['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="Oldalak" class="d-flex justify-content-center justify-content-md-start">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=/logs&p=<?= max(1, $page-1) ?>">Előző</a>
            </li>

            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=/logs&p=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=/logs&p=<?= min($pages, $page+1) ?>">Következő</a>
            </li>
        </ul>
    </nav>
</div>

<style>
.table td {
    word-break: break-word;
    max-width: 200px;
}
.table td:nth-child(6) { 
    max-width: 300px;
    text-align: left !important;
}
</style>