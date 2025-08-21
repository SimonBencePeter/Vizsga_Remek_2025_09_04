<?php $h = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
   <h2>Cégek nyilvántartása</h2>
   <?php if (Session::isAdmin()): ?>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
      Új cég rögzítése
    </button>
  <?php endif; ?>
  </button>
</div>
   <table class="table table-bordered table-striped table-hover text-center">
    <thead class="table-dark ">
      <tr>
        <th>Név</th>
        <th>Cím</th>
        <th>Kapcsolattartó</th>
        <th>Email</th>
        <th>Telefon</th>
        <?php if (Session::isAdmin()): ?><th>Műveletek</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($companies as $c): ?>
        <tr>
          <td><?= $h($c['name']) ?></td>
          <td><?= $h($c['address']) ?></td>
          <td><?= $h($c['contact_person']) ?></td>
          <td><?= $h($c['contact_email']) ?></td>
          <td><?= $h($c['contact_phone']) ?></td>
          <?php if (Session::isAdmin()): ?>
            <td>
              
              <button class="btn btn-sm btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#editCompanyModal<?= (int)$c['id'] ?>">
               <i class="bi bi-pencil"></i>
              </button>
              <a href="?page=/companies/delete&id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('Biztosan törlöd?')"><i class="bi bi-trash"></i></a>
            </td>
          <?php endif; ?>
        </tr>

       
        <div class="modal fade" id="editCompanyModal<?= (int)$c['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form method="POST" action="?page=/companies/update">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <div class="modal-header">
                  <h5 class="modal-title">Cég szerkesztése - <?= $h($c['name']) ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Név</label>
                      <input type="text" name="name" class="form-control" value="<?= $h($c['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Város</label>
                      <input type="text" name="city" class="form-control" value="<?= $h($c['city']) ?>">
                    </div>
                    <div class="col-md-12">
                      <label class="form-label">Cím</label>
                      <input type="text" name="address" class="form-control" value="<?= $h($c['address']) ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Kapcsolattartó</label>
                      <input type="text" name="contact_person" class="form-control" value="<?= $h($c['contact_person']) ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Email</label>
                      <input type="email" name="contact_email" class="form-control" value="<?= $h($c['contact_email']) ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Telefon</label>
                      <input type="text" name="contact_phone" class="form-control" value="<?= $h($c['contact_phone']) ?>">
                    </div>
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
</div>

<div class="modal fade" id="createCompanyModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="?page=/companies/create">
        <div class="modal-header">
          <h5 class="modal-title">Új cég</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Név</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Város</label>
              <input type="text" name="city" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label">Cím</label>
              <input type="text" name="address" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Kapcsolattartó</label>
              <input type="text" name="contact_person" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="contact_email" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Telefon</label>
              <input type="text" name="contact_phone" class="form-control">
            </div>
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
