<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include '../koneksi.php';

$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
header("Location: dashboard.php?page=barang&success=Barang+berhasil+dihapus");