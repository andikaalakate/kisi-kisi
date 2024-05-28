<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'db_akademik';

    $koneksi = mysqli_connect($hostname, $username, $password, $database);

    if (mysqli_connect_errno()) {
        echo '<h1>Koneksi Gagal : ' . mysqli_connect_error() . '</h1>';
    }