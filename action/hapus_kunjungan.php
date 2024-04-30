<?php
session_start();
require_once "../database.php";

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);

    // Query untuk menghapus data kunjungan berdasarkan ID
    $query = "DELETE FROM kunjungan WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Data berhasil dihapus";
        header("Location: ../kunjungan.php");
        exit();
    } else {
        $_SESSION['error'] = "Data Gagal dihapus";
        header("Location: ../kunjungan.php");
        exit();
    }
} else {
    header("Location: ../kunjungan.php");
    exit();
}
