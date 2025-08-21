<div class="container py-4">
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Felhasználók</h2>
            <a href="?page=/users/create" class="btn btn-primary">Új felhasználó rögzítése</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Felhasználónév</th>
                        <th>Név</th>
                        <th>Szerep</th>
                        <th style="width:180px;">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= (int)$u['id'] ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['full_name']) ?></td>
                            <td>
                                <span class="badge bg-<?= $u['role'] === 'admin' ? 'primary' : 'secondary' ?>">
                                    <?= htmlspecialchars($u['role']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="?page=/users/edit&id=<?= (int)$u['id'] ?>" 
                                   class="btn btn-sm btn-warning me-1" 
                                   title="Szerkesztés">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="?page=/users/delete&id=<?= (int)$u['id'] ?>" 
                                   class="btn btn-sm btn-danger" 
                                   title="Törlés"
                                   onclick="return confirm('Biztos törlöd?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    </div> 
</div>