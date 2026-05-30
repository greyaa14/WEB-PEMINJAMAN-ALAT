<?php
include __DIR__ . '/../koneksi.php';

/** @var mysqli $conn */

$id_barang    = (int)$_POST['id_barang'];
$nama         = mysqli_real_escape_string($conn, trim($_POST['nama_peminjam']));
$kelas        = mysqli_real_escape_string($conn, trim($_POST['kelas']));
$jumlah       = (int)$_POST['jumlah'];
$tgl_pinjam   = $_POST['tgl_pinjam'];
$keperluan    = mysqli_real_escape_string($conn, trim($_POST['keperluan'] ?? ''));

// Validasi stok
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id=$id_barang"));
if (!$barang) {
    header("Location: daftar_alat.php?error=Barang+tidak+ditemukan");
    exit;
}
if ($jumlah > $barang['stok']) {
    header("Location: daftar_alat.php?error=Jumlah+melebihi+stok+tersedia");
    exit;
}
if ($jumlah < 1) {
    header("Location: daftar_alat.php?error=Jumlah+minimal+1");
    exit;
}

// Simpan peminjaman dengan status menunggu
$query = mysqli_query($conn, "
    INSERT INTO peminjaman (id_barang, nama_peminjam, kelas, jumlah, tgl_pinjam, status)
    VALUES ($id_barang, '$nama', '$kelas', $jumlah, '$tgl_pinjam', 'menunggu')
");

if ($query) {
    header("Location: daftar_alat.php?success=Pengajuan+berhasil+dikirim!+Tunggu+konfirmasi+dari+admin.");
} else {
    header("Location: daftar_alat.php?error=Gagal+mengirim+pengajuan.+Coba+lagi.");
}