<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'pusling';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi Database Gagal " . mysqli_connect_error();
}
