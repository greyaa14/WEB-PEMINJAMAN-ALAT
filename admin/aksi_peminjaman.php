<?php
session_start();
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit; 
}

include '../koneksi.php';

$id   = (int)$_GET['id'];
$aksi = $_GET['aksi'];

// Ambil data peminjaman
$pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM peminjaman WHERE id=$id"));

if (!$pinjam) {
    header("Location: dashboard.php?page=peminjaman&error=Data+tidak+ditemukan");
    exit;
}

// KONFIRMASI
if ($aksi === 'konfirmasi' && $pinjam['status'] === 'menunggu') {

    // Ambil stok sekarang
    $barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM barang WHERE id = {$pinjam['id_barang']}"));

    if (!$barang) {
        header("Location: dashboard.php?page=peminjaman&error=Barang+tidak+ditemukan");
        exit;
    }

    // Validasi stok cukup
    if ($barang['stok'] < $pinjam['jumlah']) {
        header("Location: dashboard.php?page=peminjaman&error=Stok+tidak+mencukupi");
        exit;
    }

    // Kurangi stok
    mysqli_query($conn, "
        UPDATE barang 
        SET stok = stok - {$pinjam['jumlah']} 
        WHERE id = {$pinjam['id_barang']}
    ");

    // Update status
    mysqli_query($conn, "
        UPDATE peminjaman 
        SET status='dipinjam' 
        WHERE id=$id
    ");

    header("Location: dashboard.php?page=peminjaman&success=Peminjaman+dikonfirmasi");
}

// KEMBALI
elseif ($aksi === 'kembali' && $pinjam['status'] === 'dipinjam') {

    // Tambah stok kembali
    mysqli_query($conn, "
        UPDATE barang 
        SET stok = stok + {$pinjam['jumlah']} 
        WHERE id = {$pinjam['id_barang']}
    ");

    // Update status + tanggal kembali
    mysqli_query($conn, "
        UPDATE peminjaman 
        SET status='dikembalikan', tgl_kembali=NOW() 
        WHERE id=$id
    ");

    header("Location: dashboard.php?page=peminjaman&success=Barang+berhasil+dikembalikan");
}

// TOLAK
elseif ($aksi === 'tolak' && $pinjam['status'] === 'menunggu') {

    mysqli_query($conn, "
        UPDATE peminjaman 
        SET status='ditolak' 
        WHERE id=$id
    ");

    header("Location: dashboard.php?page=peminjaman&success=Peminjaman+ditolak");
}

// INVALID
else {
    header("Location: dashboard.php?page=peminjaman&error=Aksi+tidak+valid");
}