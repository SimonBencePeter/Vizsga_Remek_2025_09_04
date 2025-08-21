<!doctype html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <title>Bejelentkezés</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-body p-4">
            <h1 class="h3 mb-4 text-center">Bejelentkezés</h1>
            
<?php if (!empty($_SESSION['flash'])): ?>
  <?php foreach ((array)$_SESSION['flash'] as $msg): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars((string)$msg, ENT_QUOTES, 'UTF-8') ?>
    </div>
  <?php endforeach; ?>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>



            <form method="post" action="?page=/login">
              <div class="mb-3">
                <label class="form-label">Felhasználónév</label>
                <input type="text" name="username" class="form-control" required autofocus>
              </div>
              <div class="mb-3">
                <label class="form-label">Jelszó</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button class="btn btn-primary w-100">Bejelentkezés</button>
            </form>
          </div>
        </div>
        <p class="text-center text-muted mt-3 small">IT Eszköz nyilvántartó</p>
      </div>
    </div>
  </div>
</body>
</html>
