<?php
session_start();
include '../koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=? AND password=?");
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data) {
    $_SESSION['login'] = true;
    $_SESSION['username'] = $data['username'];

    header("Location: dashboard.php");
} else {
    header("Location: login.php?error=1");
}