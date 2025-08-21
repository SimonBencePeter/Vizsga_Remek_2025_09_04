<!doctype html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


  <div class="container my-5">
    <?php if (!empty($user)): ?>
      <div class="alert alert-success">
        Üdv, <strong><?= htmlspecialchars($user['full_name'] ?: $user['username']) ?></strong> 
        (<?= htmlspecialchars($user['role']) ?>)!
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-4">
        <div class="card text-bg-primary mb-3">
          <div class="card-body">
            <h5 class="card-title">Cégek</h5>
            <p class="card-text">Cégek nyilvántartása</p>
            <a href="?page=/companies" class="btn btn-light btn-sm">Megnyitás</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Eszközök</h5>
            <p class="card-text">Eszközök kezelése</p>
            <a href="?page=/devices" class="btn btn-light btn-sm">Megnyitás</a>
          </div>
        </div>
      </div>
          <?php if (Session::isAdmin()): ?>
          <div class="col-md-4">
        <div class="card text-bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">Logok</h5>
            <p class="card-text">Naplózott műveletek</p>
            <a href="?page=/logs" class="btn btn-light btn-sm">Megnyitás</a>
          </div>

        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
