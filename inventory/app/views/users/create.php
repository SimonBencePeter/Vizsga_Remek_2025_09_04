<div class="container py-4 ">
  <h2 class="text-center">Új felhasználó létrehozása</h2>
  <div class="row justify-content-center">
    <div class="col-md-4">
      <form method="post" action="?page=/users/create">
        <div class="mb-3">
          <label class="form-label"><b>Felhasználónév</b></label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label"><b>Teljes név</b></label>
          <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label"><b>Jelszó</b></label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label"><b>Szerep</b></label>
          <select name="role" class="form-select">
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <button class="btn btn-success">Mentés</button>
        <a href="?page=/users" class="btn btn-secondary">Mégse</a>
      </form>
    </div>
  </div>
</div>