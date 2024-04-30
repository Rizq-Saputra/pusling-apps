<?php
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
include "../database.php";

$query = "SELECT * FROM kunjungan WHERE tanggal = '$keyword'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . date('d-m-Y', strtotime($row['tanggal'])) . '</td>';
        echo '<td>' . htmlspecialchars($row['tempat_kunjungan']) . '</td>';
        echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
        echo '<td>' . htmlspecialchars($row['kontak']) . '</td>';
        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
        echo '<td>' . htmlspecialchars($row['petugas_layanan']) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">Tidak ada data kunjungan</td></tr>';
}
?>
