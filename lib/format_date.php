<?php
// Fungsi untuk mengubah format tanggal menjadi format bahasa Indonesia
function formatDate($dateString) {
    $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $dayOfWeek = date('w', strtotime($dateString));
    $dayName = $nama_hari[$dayOfWeek];

    $bulan = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );
    
    $formattedDate = $dayName . ' ' . date('j', strtotime($dateString)) . ' ' . $bulan[date('F', strtotime($dateString))] . ' ' . date('Y', strtotime($dateString));
    return $formattedDate;
}