<div class="container py-4">
  <h2>Felhasználó szerkesztése</h2>
  <form method="post" action="?page=/users/update">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <div class="mb-3">
      <label class="form-label"><b>Teljes név</b></label>
      <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label"><b>Szerep</b></label>
      <select name="role" class="form-select">
        <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
      </select>
    </div>
    <button class="btn btn-success">Mentés</button>
    <a href="?page=/users" class="btn btn-secondary">Mégse</a>
  </form>
</div>
