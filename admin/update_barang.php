<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include '../koneksi.php';

$id        = (int)$_POST['id'];
$nama      = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));
$deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
$stok      = (int)$_POST['stok'];

// Cek apakah ada foto baru
$foto_query = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $ext     = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];
    if (!in_array($ext, $allowed)) {
        header("Location: dashboard.php?page=barang&error=Format+foto+tidak+didukung");
        exit;
    }
    $nama_file  = 'barang_' . time() . '.' . $ext;
    $upload_dir = '../assets/img/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $nama_file)) {
        $foto_query = ", foto='$nama_file'";
    }
}

$query = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', deskripsi='$deskripsi', stok=$stok $foto_query WHERE id=$id");

if ($query) {
    header("Location: dashboard.php?page=barang&success=Barang+berhasil+diupdate");
} else {
    header("Location: dashboard.php?page=barang&error=Gagal+update+data");
}