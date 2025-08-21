<?php $h = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); ?>

<div class="container mt-4">


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Eszközök</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Új eszköz rögzítése
        </button>
    </div>


    <form class="row g-2 mb-3" method="get">
        <input type="hidden" name="page" value="/devices">

        <div class="col-md-3">
            <label class="form-label"><b>Cég</b></label>
            <select name="company_id" class="form-select">
                <option value="">– mind –</option>
                <?php foreach ($companies as $c): ?>
                <option value="<?= (int)$c['id'] ?>" <?= ($filters['company_id']==$c['id']?'selected':'') ?>>
                    <?= $h($c['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label"><b>Eszköz neve</b></label>
            <input type="text" name="device_name" class="form-control" value="<?= $h($filters['device_name']) ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label"><b>Sorozatszám</b></label>
            <input type="text" name="serial_number" class="form-control" value="<?= $h($filters['serial_number']) ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label"><b>Típus</b></label>
            <select name="device_type" class="form-select">
                <option value="">– mind –</option>
                <?php foreach (['szerver','gép','laptop','monitor','nyomtató','telefon','switch','router'] as $type): ?>
                <option value="<?= $type ?>" <?= ($filters['device_type']==$type?'selected':'') ?>><?= ucfirst($type) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label"><b>Státusz</b></label>
            <select name="status" class="form-select">
                <option value="">– mind –</option>
                <?php foreach (['kiadható','kiadva','szerelés alatt','selejtezett'] as $st): ?>
                <option value="<?= $st ?>" <?= ($filters['status']===$st?'selected':'') ?>><?= ucfirst($st) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label"><b>Számlázva</b></label>
            <select name="is_invoiced" class="form-select">
                <option value="">– mind –</option>
                <option value="1" <?= ($filters['is_invoiced'] === '1' ? 'selected' : '') ?>>Igen</option>
                <option value="0" <?= ($filters['is_invoiced'] === '0' ? 'selected' : '') ?>>Nem</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Szűrés</button>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <a class="btn btn-secondary w-100" href="?page=/devices">Szűrők törlése</a>
        </div>
    </form>

    
    <div class="mb-2 text-muted">
        Összes találat: <strong><?= (int)$total ?></strong> | Oldal:
        <strong><?= (int)$pageNum ?>/<?= (int)$pages ?></strong>
    </div>


    <table class="table table-striped table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Típus</th>
                <th>Sorozatszám</th>
                <th>Cég</th>
                <th>Számlázva</th>
                <th>Státusz</th>
                <th style="width:180px;">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devices as $d): ?>
            <tr>
                <td><?= (int)$d['id'] ?></td>
                <td class="text-start"><?= $h($d['device_name']) ?></td>
                <td><?= $h($d['device_type']) ?></td>
                <td><?= $h($d['serial_number']) ?></td>
                <td><?= $h($d['company_name'] ?? '-') ?></td>
                <td>
                    <?php if (!empty($d['is_invoiced'])): ?>
                    <i class="bi bi-check-lg text-success" title="Számlázva"></i>
                    <?php else: ?>
                    <i class="bi bi-x-lg text-danger" title="Nincs számlázva"></i>
                    <?php endif; ?>
                </td>
                <td><?= $h($d['status']) ?></td>
                <td>

                    <button class="btn btn-info btn-sm me-1" title="Részletek" data-bs-toggle="modal"
                        data-bs-target="#viewModal<?= (int)$d['id'] ?>">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <a href="?page=/devices/delete&id=<?= (int)$d['id'] ?>" class="btn btn-danger btn-sm" title="Törlés"
                        onclick="return confirm('Biztosan törlöd?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>

            <div class="modal fade" id="viewModal<?= (int)$d['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Eszköz részletei – <?= $h($d['device_name']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Eszköz neve</label>
                                    <div class="form-control-plaintext"><?= $h($d['device_name']) ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Típus</label>
                                    <div class="form-control-plaintext"><?= $h($d['device_type']) ?></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Sorozatszám</label>
                                    <div class="form-control-plaintext"><?= $h($d['serial_number']) ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Cég</label>
                                    <div class="form-control-plaintext"><?= $h($d['company_name'] ?? '-') ?></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Státusz</label>
                                    <div class="form-control-plaintext"><?= $h($d['status']) ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Számlázva</label>
                                    <div class="form-control-plaintext">
                                        <?= !empty($d['is_invoiced']) ? 'Igen' : 'Nem' ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Leírás</label>
                                    <div class="form-control-plaintext"
                                        style="word-break: break-word; max-height: 100px;">
                                        <?= nl2br($h($d['description'])) ?>
                                    </div>
                                </div>

                                <?php if (!empty($d['created_at']) || !empty($d['updated_at'])): ?>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Létrehozva</label>
                                    <div class="form-control-plaintext"><?= $h($d['created_at'] ?? '') ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Módosítva</label>
                                    <div class="form-control-plaintext"><?= $h($d['updated_at'] ?? '') ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                            <button class="btn btn-warning" data-bs-target="#editModal<?= (int)$d['id'] ?>"
                                data-bs-toggle="modal">
                                Szerkesztés
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal<?= (int)$d['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="?page=/devices/update&id=<?= (int)$d['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Eszköz módosítása – <?= $h($d['device_name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Eszköz neve</label>
                        <input type="text" class="form-control" name="device_name"
                            value="<?= $h($d['device_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Típus</label>
                        <select class="form-select" name="device_type" required>
                            <?php foreach (['szerver','gép','laptop','monitor','nyomtató','telefon','switch','router'] as $type): ?>
                            <option value="<?= $type ?>"
                                <?= ($d['device_type']===$type ? 'selected' : '') ?>><?= ucfirst($type) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sorozatszám</label>
                        <input type="text" class="form-control" name="serial_number"
                            value="<?= $h($d['serial_number']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cég</label>
                        <select class="form-select" name="company_id">
                            <option value="">-- nincs hozzárendelve --</option>
                            <?php foreach ($companies as $c): ?>
                            <option value="<?= (int)$c['id'] ?>"
                                <?= ($d['company_id']==$c['id']?'selected':'') ?>><?= $h($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Státusz</label>
                        <select class="form-select" name="status">
                            <?php foreach (['kiadható','kiadva','szerelés alatt','selejtezett'] as $status): ?>
                            <option value="<?= $status ?>" <?= ($d['status']===$status?'selected':'') ?>>
                                <?= ucfirst($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="is_invoiced" value="1"
                            id="invoiced<?= (int)$d['id'] ?>"
                            <?= !empty($d['is_invoiced']) ? 'checked' : '' ?>>
                        <label for="invoiced<?= (int)$d['id'] ?>" class="form-check-label">Számlázva</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leírás</label>
                        <textarea class="form-control" name="description" rows="4"><?= $h($d['description']) ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>


            <?php endforeach; ?>
        </tbody>
    </table>


    <nav aria-label="Oldalak">
        <ul class="pagination">
            <?php
        $makeLink = function($p) use ($baseQS) {
          $qs = $baseQS ? ($baseQS . '&p=' . $p) : ('page=/devices&p=' . $p);
          return '?'.$qs;
        };
      ?>
            <li class="page-item <?= $pageNum<=1?'disabled':'' ?>">
                <a class="page-link" href="<?= $makeLink(max(1,$pageNum-1)) ?>">Előző</a>
            </li>
            <?php for ($i=1; $i<=$pages; $i++): ?>
            <li class="page-item <?= $i==$pageNum?'active':'' ?>">
                <a class="page-link" href="<?= $makeLink($i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $pageNum>=$pages?'disabled':'' ?>">
                <a class="page-link" href="<?= $makeLink(min($pages,$pageNum+1)) ?>">Következő</a>
            </li>
        </ul>
    </nav>
</div>


<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="?page=/devices/create">
                <div class="modal-header">
                    <h5 class="modal-title">Új eszköz hozzáadása</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Eszköz neve</label>
                        <input type="text" class="form-control" name="device_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Típus</label>
                        <select class="form-select" name="device_type" required>
                            <option value="">-- válassz --</option>
                            <?php foreach (['szerver','gép','laptop','monitor','nyomtató','telefon','switch','router'] as $type): ?>
                            <option value="<?= $type ?>"><?= ucfirst($type) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sorozatszám</label>
                        <input type="text" class="form-control" name="serial_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cég</label>
                        <select class="form-select" name="company_id">
                            <option value="">-- nincs hozzárendelve --</option>
                            <?php foreach ($companies as $c): ?>
                            <option value="<?= (int)$c['id'] ?>"><?= $h($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Státusz</label>
                        <select class="form-select" name="status">
                            <?php foreach (['kiadható','kiadva','szerelés alatt','selejtezett'] as $st): ?>
                            <option value="<?= $st ?>"><?= ucfirst($st) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="is_invoiced" value="1" id="invoicedNew">
                        <label for="invoicedNew" class="form-check-label">Számlázva</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leírás</label>
                        <textarea class="form-control" name="description" rows="4" placeholder="Pl.: Akkucsere, tisztítás, stb."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                    <button type="submit" class="btn btn-success">Hozzáadás</button>
                </div>
            </form>
        </div>
    </div>
</div>
