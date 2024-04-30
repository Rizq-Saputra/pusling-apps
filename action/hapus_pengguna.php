<?php
session_start();
require_once "../database.php";

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);

    $query = "DELETE FROM pengguna WHERE id_pengguna = $id";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Data berhasil dihapus";
        header("Location: ../pengaturan.php");
        exit();
    } else {
        $_SESSION['error'] = "Data Gagal dihapus";
        header("Location: ../pengaturan.php");
        exit();
    }
} else {
    header("Location: ../pengaturan.php");
    exit();
}
