<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Kunjungan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }

        th {
            background-color: #FFCE26;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<p align="center" style="font-weight:bold;font-size:16pt">Data Kunjungan</p>


<?php
    // Set header untuk download file Excel
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=data-kunjungan.xls"); 

    require_once "../database.php";
    $query = "SELECT * FROM kunjungan WHERE 1";

    // Menjalankan query
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah ada data yang ditemukan
    if(mysqli_num_rows($result) > 0) {
        echo '<table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tempat Kunjungan</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Kontak</th>
                        <th>Jumlah Siswa</th>
                        <th>Petugas Layanan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
            
            $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        while($row = mysqli_fetch_assoc($result)) {
            // Menggunakan tanggal dalam bahasa Indonesia
            $tanggal_bahasa_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));

            echo '<tr>';
            echo '<td>' . $tanggal_bahasa_indonesia . '</td>';
            echo '<td>' . $row['tempat_kunjungan'] . '</td>';
            echo '<td>' . $row['alamat'] . '</td>';
            echo '<td>' . $row['kecamatan'] . '</td>';
			echo '<td style="mso-number-format:\@;">' . $row['kontak'] . '</td>';
			echo '<td>' . $row['jumlah_siswa'] . '</td>';
			echo '<td>' . $row['petugas_layanan'] . '</td>';
            
            // Menggunakan status untuk menentukan kelas CSS
            $status_class = "";
            switch ($row['status']) {
                case "Belum Di kunjungi":
                    $status_class = "uncompleted";
                    break;
                case "Sudah Dikunjungi":
                    $status_class = "completed";
                    break;
                case "Batal Dikunjungi":
                    $status_class = "canceled";
                    break;
                default:
                    $status_class = "";
                    break;
            }
            echo '<td><span class="status ' . $status_class . '">' . $row['status'] . '</span></td>';            
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p align="center">Tidak ada Data Kunjungan yang ditemukan.</p>';
    }

    mysqli_close($koneksi);
?>

<p align="center">
    <input type="button" value="Export Excel" onclick="window.open('../kunjungan.php')">
</p>

</body>
</html>
