<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include '../koneksi.php';

$nama      = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));
$deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
$stok      = (int)$_POST['stok'];
$foto      = '';

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
        $foto = $nama_file;
    }
}

$query = mysqli_query($conn, "INSERT INTO barang (nama_barang, deskripsi, stok, foto) VALUES ('$nama','$deskripsi',$stok,'$foto')");

if ($query) {
    header("Location: dashboard.php?page=barang&success=Barang+berhasil+ditambahkan");
} else {
    header("Location: dashboard.php?page=barang&error=Gagal+menyimpan+data");
}