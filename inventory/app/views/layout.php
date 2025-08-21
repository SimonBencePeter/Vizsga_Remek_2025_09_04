<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Eszköznyilvántartó</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body  style="background-color: #B0C4DE;">
   <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container">
    <a class="navbar-brand" href="?page=/">Eszköznyilvántartó</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="?page=/companies">Cégek</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=/devices">Eszközök</a></li>
        <?php if (Session::isAdmin()): ?>
          <li class="nav-item"><a class="nav-link" href="?page=/logs">Logok</a></li>
          <li class="nav-item"><a class="nav-link" href="?page=/users">Felhasználók</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="?page=/users/change-password">Jelszó módosítás</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="?page=/logout">Kijelentkezés</a></li>
      </ul>
    </div>
  </div>
</nav>
  <div class="container">
    <?php include $viewFile; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
