<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eUsername = $_POST['username'];
    $ePassword = md5($_POST['password']);

    $sqlLogin = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$eUsername' AND password = '$ePassword'");
    $result =  mysqli_num_rows($sqlLogin);

    if ($result > 0) {
        $r =  mysqli_fetch_array($sqlLogin);
        $_SESSION['status_login'] = 'sudah_login';
        $_SESSION['nama'] = $r['username'];
        $_SESSION['role'] = $r['role'];

        if ($_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'admin') {
            echo json_encode(['status' => 'success', 'redirect' => '../dashboard/admin/']);
        } else {
            echo json_encode(['status' => 'success', 'redirect' => '../dashboard/user/']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Maaf, Username atau Password yang anda masukkan salah.']);
    }
}

$koneksi->close();
