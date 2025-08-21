<div class="container py-4">
    <h2 class="text-center">Jelszó módosítása</h2>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <?php 
            $flashes = Session::getFlashes();
            if (!empty($flashes)): 
            ?>
                <?php foreach($flashes as $flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : ($flash['type'] === 'danger' ? 'danger' : 'warning') ?> alert-dismissible fade show">
                        <?= htmlspecialchars($flash['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="post" action="?page=/users/change-password">
                <div class="mb-3">
                    <label class="form-label"><b>Új jelszó</b></label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Új jelszó mégegyszer</b></label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Mentés</button>
                <a href="?page=/" class="btn btn-secondary">Vissza</a>
            </form>
        </div>
    </div>
</div>