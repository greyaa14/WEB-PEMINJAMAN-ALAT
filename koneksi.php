<?php
$conn = mysqli_connect("localhost", "root", "", "peminjaman_server");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>