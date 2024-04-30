<?php

$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
include "../database.php";

$query = "SELECT tanggal, alamat, tempat_kunjungan, status, id FROM kunjungan WHERE tanggal = '$keyword'";
$result = mysqli_query($koneksi, $query);

$tempat_kunjungan = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $status_class = "";
        $icon_class = "";

        switch ($row['status']) {
            case "Belum Di kunjungi":
            case "Batal Dikunjungi":
                $status_class = "not-completed";
                $icon_class = "bx bxs-check-circle";
                $class_text = "belum";
                break;
            case "Sudah Dikunjungi":
                $status_class = "completed";
                $class_text = "sudah";
                break;
            default:
                $status_class = "";
                $icon_class = "";
                break;
        }

        $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $tanggal_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));

        $tempat_kunjungan .= '<li class="' . $status_class . '">';
        $tempat_kunjungan .= '<div class="text">';
        $tempat_kunjungan .= '<p class="' . $class_text . '">' . $row['status'] . '</p>';
        $tempat_kunjungan .= '<p>' . $row['tempat_kunjungan'] . '</p>';
        $tempat_kunjungan .= '<p class="text-desc">' . $row['alamat'] . '</p>';
        $tempat_kunjungan .= '</div>';

        if (!empty($icon_class)) {
            $tempat_kunjungan .= '<form method="post"><input type="hidden" name="place_id" value="' . $row['id'] . '"><button type="submit" class="update-status-button"><i class="' . $icon_class . '"></i></button></form>';
        }

        $tempat_kunjungan .= '</li>';
    }
} else {
    $tempat_kunjungan = '<li class="not-completed">Tidak ada tempat kunjungan pada tanggal yang dipilih.</li>';
}

echo $tempat_kunjungan;
