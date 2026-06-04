<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    // Validasi
    if (empty($username) || empty($password)) {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Username dan password tidak boleh kosong!"));
        exit;
    }

    if ($password !== $konfirmasi) {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Password dan konfirmasi tidak sama!"));
        exit;
    }

    if (strlen($password) < 6) {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Password minimal 6 karakter!"));
        exit;
    }

    // Cek username sudah ada
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($conn, $username) . "'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Username '$username' sudah digunakan!"));
        exit;
    }

    $hashed = md5($password);
    $q = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('" . mysqli_real_escape_string($conn, $username) . "', '$hashed')");

    if ($q) {
        header("Location: dashboard.php?page=admin&success=" . urlencode("Admin '$username' berhasil ditambahkan!"));
    } else {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Gagal menambahkan admin!"));
    }
    exit;
}

header("Location: dashboard.php");
exit;