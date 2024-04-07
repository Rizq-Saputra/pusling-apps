<?php
require "../database.php";

$query = "SELECT * FROM kunjungan WHERE status = 'Belum Di kunjungi' ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);
$schedules = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[] = $row;
    }
}

// Kirim daftar jadwal sebagai respons JSON
header('Content-Type: application/json');
echo json_encode($schedules);
?>
