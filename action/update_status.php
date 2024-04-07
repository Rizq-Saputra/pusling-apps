<?php
session_start();
require "../database.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Mengambil ID dari permintaan
    $place_id = $_GET["id"];
    $place_id = mysqli_real_escape_string($koneksi, $place_id);

    // Update status ke "Sudah Dikunjungi" dalam database
    $update_query = "UPDATE kunjungan SET status = 'Sudah Dikunjungi' WHERE id = '$place_id'";
    $result = mysqli_query($koneksi, $update_query);

    if ($result) {
        $_SESSION['success'] = "Berhasil Mengubah Status";
        header("Location: ../jadwal.php");
    } else {
        // Jika terjadi kesalahan, atur pesan error
        $_SESSION['error'] = "Gagal Mengubah Status";
        header("Location: ../jadwal.php");
    }
}
exit();
?>
