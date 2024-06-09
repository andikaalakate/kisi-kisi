<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eUsername = $_POST['username'];
    $ePassword = md5($_POST['password']);

    // Cek di tabel admin
    $sqlLoginAdmin = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$eUsername' AND password = '$ePassword'");
    $resultAdmin = mysqli_num_rows($sqlLoginAdmin);

    // Jika ada di tabel admin, lakukan login
    if ($resultAdmin > 0) {
        $r = mysqli_fetch_array($sqlLoginAdmin);
        $_SESSION['status_login'] = 'sudah_login';
        $_SESSION['nama'] = $r['username'];
        $_SESSION['role'] = $r['role'];

        if ($_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'admin') {
            echo json_encode(['status' => 'success', 'redirect' => '../dashboard/admin/']);
        } else {
            echo json_encode(['status' => 'success', 'redirect' => '../dashboard/user/']);
        }
    } else {
        // Jika tidak ada di tabel admin, cek di tabel guru
        $sqlLoginGuru = mysqli_query($koneksi, "SELECT * FROM guru WHERE kode_guru = '$eUsername' AND password = '$ePassword'");
        $resultGuru = mysqli_num_rows($sqlLoginGuru);

        if ($resultGuru > 0) {
            $r = mysqli_fetch_array($sqlLoginGuru);
            $_SESSION['status_login'] = 'sudah_login';
            $_SESSION['nama'] = $r['nama'];
            $_SESSION['username'] = $r['kode_guru'];
            $_SESSION['role'] = 'guru'; // Misalkan role untuk guru adalah 'guru'

            echo json_encode(['status' => 'success', 'redirect' => '../dashboard/user/']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Maaf, Username atau Password yang anda masukkan salah.']);
        }
    }
}

$koneksi->close();