<?php
session_start();
require "database.php";

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);

    // Pastikan ada session login
    // if (!isset($_SESSION['username'])) {
    //     die("Akses tidak sah");
    // }

    // Query untuk menghapus data kunjungan berdasarkan ID
    $query = "DELETE FROM kunjungan WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Data berhasil dihapus";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Data Gagal dihapus";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
