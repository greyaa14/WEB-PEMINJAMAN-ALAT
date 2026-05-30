<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — SiPinjam</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

  <!-- CSS Login -->
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body class="login-page">

  <!-- Dot grid background -->
  <div class="login-dots"></div>

  <div class="login-wrapper">

    <!-- Brand -->
<div class="login-brand">
  <div class="login-brand-icon">
    <img src="../assets/img/logo-smk.png" alt="SMK Ketintang" />
  </div>
  <div class="login-brand-name">SiPinjam</div>
</div>

    <!-- Card -->
    <div class="login-card">

      <div class="login-title">Selamat Datang 👋</div>
      <div class="login-subtitle">Masuk sebagai admin untuk mengelola sistem peminjaman</div>

      <?php if (isset($_GET['error'])): ?>
        <div class="login-alert">
          <i class="bi bi-exclamation-circle-fill"></i>
          Username atau password salah
        </div>
      <?php endif; ?>

      <form action="proses_login.php" method="POST">

        <!-- Username -->
        <div class="login-input-wrap">
          <i class="bi bi-person-fill login-input-icon"></i>
          <input
            type="text"
            name="username"
            class="form-control"
            placeholder="Masukkan username"
            required
            autocomplete="username"
          >
        </div>

        <!-- Password -->
        <div class="login-input-wrap">
          <i class="bi bi-lock-fill login-input-icon"></i>
          <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Masukkan password"
            required
            autocomplete="current-password"
          >
        </div>

        <button type="submit" class="login-btn">
          <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>

      </form>

      <hr class="login-divider">
      <div class="login-footer">
        © 2026 SiPinjam — SMKS Ketintang Surabaya
      </div>

    </div>

    <!-- Back to home -->
    <a href="../index.php" class="login-back">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>


  </div>

</body>
</html>