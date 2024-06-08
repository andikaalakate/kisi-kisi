<?php

session_start();

// Periksa apakah role user adalah super_admin atau admin
if (isset($_SESSION['role']) && ($_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'admin')) {
    header('Location: ./admin/');
    exit(); // Pastikan untuk keluar dari skrip setelah melakukan redirect
} elseif (isset($_SESSION['role']) && ($_SESSION['role'] == 'user')) {
    // Jika role tidak sesuai, bisa dilakukan aksi lain, seperti redirect ke halaman lain atau menampilkan pesan kesalahan
    header('Location: ./user/');
    exit();
} elseif (isset($_SESSION['role']) && ($_SESSION['role'] == 'guru')) {
    // Jika role tidak sesuai, bisa dilakukan aksi lain, seperti redirect ke halaman lain atau menampilkan pesan kesalahan
    header('Location: ./user/');
    exit();
} else {
    header('Location: ../../login');
    exit();
}
