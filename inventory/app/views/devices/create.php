<div class="container mt-4">
  <h2>+ Új eszköz</h2>
  <form method="POST" action="?page=/devices/create">
    <div class="mb-3">
      <label class="form-label">Eszköz neve</label>
      <input type="text" name="device_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Típus</label>
      <select name="device_type" class="form-select" required>
        <option value="laptop">Laptop</option>
        <option value="gép">Gép</option>
        <option value="monitor">Monitor</option>
        <option value="szerver">Szerver</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Sorozatszám</label>
      <input type="text" name="serial_number" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Cég</label>
      <select name="company_id" class="form-select">
        <option value="">-- nincs --</option>
        <?php foreach ($companies as $c): ?>
          <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Státusz</label>
      <select name="status" class="form-select">
        <option value="kiadható">Kiadható</option>
        <option value="kiadva">Kiadva</option>
        <option value="szerelés alatt">Szerelés alatt</option>
        <option value="selejtezett">Selejtezett</option>
      </select>
    </div>
    <div class="form-check mb-3">
      <input type="checkbox" name="is_invoiced" value="1" class="form-check-input">
      <label class="form-check-label">Számlázva</label>
    </div>
    <div class="mb-3">
      <label class="form-label">Leírás</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">💾 Mentés</button>
    <a href="?page=/devices" class="btn btn-secondary">Mégse</a>
  </form>
</div>
