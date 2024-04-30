<?php
require_once('../database.php');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM kunjungan WHERE 1";

if ($filter === 'belum') {
    $query .= " AND status = 'Belum Di kunjungi'";
} elseif ($filter === 'sudah') {
    $query .= " AND status = 'Sudah Dikunjungi'";
}

if (!empty($searchKeyword)) {
    $query .= " AND (tempat_kunjungan LIKE '%$searchKeyword%' OR kecamatan LIKE '%$searchKeyword%' OR kontak LIKE '%$searchKeyword%' OR petugas_layanan LIKE '%$searchKeyword%')";
}

$result = mysqli_query($koneksi, $query);

$schedules = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[] = $row;
    }
}

echo json_encode($schedules);
