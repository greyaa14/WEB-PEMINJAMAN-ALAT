<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = intval($_POST['id']);
    $username   = trim($_POST['username']);
    $password   = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    if (empty($username)) {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Username tidak boleh kosong!"));
        exit;
    }

    // Cek username sudah dipakai admin lain
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($conn, $username) . "' AND id != $id");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Username '$username' sudah digunakan admin lain!"));
        exit;
    }

    // Jika password diisi, update sekalian
    if (!empty($password)) {
        if ($password !== $konfirmasi) {
            header("Location: dashboard.php?page=admin&error=" . urlencode("Password dan konfirmasi tidak sama!"));
            exit;
        }
        if (strlen($password) < 6) {
            header("Location: dashboard.php?page=admin&error=" . urlencode("Password minimal 6 karakter!"));
            exit;
        }
        $hashed = md5($password);
        $q = mysqli_query($conn, "UPDATE users SET username = '" . mysqli_real_escape_string($conn, $username) . "', password = '$hashed' WHERE id = $id");
    } else {
        // Hanya update username
        $q = mysqli_query($conn, "UPDATE users SET username = '" . mysqli_real_escape_string($conn, $username) . "' WHERE id = $id");
    }

    if ($q) {
        // Update session jika yang diedit adalah diri sendiri
        if ($_SESSION['username'] === $_POST['old_username']) {
            $_SESSION['username'] = $username;
        }
        header("Location: dashboard.php?page=admin&success=" . urlencode("Data admin berhasil diperbarui!"));
    } else {
        header("Location: dashboard.php?page=admin&error=" . urlencode("Gagal memperbarui data admin!"));
    }
    exit;
}

header("Location: dashboard.php");
exit;