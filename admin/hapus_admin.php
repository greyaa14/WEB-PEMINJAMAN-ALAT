<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include '../koneksi.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: dashboard.php?page=admin&error=" . urlencode("ID tidak valid!"));
    exit;
}

// Cek total admin — minimal harus ada 1
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
if ($total <= 1) {
    header("Location: dashboard.php?page=admin&error=" . urlencode("Tidak bisa menghapus! Minimal harus ada 1 akun admin."));
    exit;
}

// Cek apakah menghapus akun sendiri
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id = $id"));
if ($row && $row['username'] === $_SESSION['username']) {
    header("Location: dashboard.php?page=admin&error=" . urlencode("Tidak bisa menghapus akun yang sedang digunakan!"));
    exit;
}

$q = mysqli_query($conn, "DELETE FROM users WHERE id = $id");

if ($q) {
    header("Location: dashboard.php?page=admin&success=" . urlencode("Akun admin berhasil dihapus!"));
} else {
    header("Location: dashboard.php?page=admin&error=" . urlencode("Gagal menghapus admin!"));
}
exit;