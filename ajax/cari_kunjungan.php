<?php
include "../database.php";

$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
$statusFilter = isset($_GET['status']) ? $_GET['status'] : "semua";

$query = "SELECT * FROM kunjungan WHERE 1";

// Tambahkan kondisi pencarian jika keyword tidak kosong
if (!empty($keyword)) {
    $query .= " AND (
                tanggal LIKE '%$keyword%' OR 
                tempat_kunjungan LIKE '%$keyword%' OR 
                alamat LIKE '%$keyword%' OR 
                kecamatan LIKE '%$keyword%' OR 
                kontak LIKE '%$keyword%' OR 
                jumlah_siswa LIKE '%$keyword%' OR 
                petugas_layanan LIKE '%$keyword%'
            )";
}

// Tambahkan kondisi filter status jika bukan "semua"
if ($statusFilter !== "semua") {
    $status = mysqli_real_escape_string($koneksi, $statusFilter);
    $query .= " AND status = '$status'";
}

// Tambahkan kondisi pengurutan berdasarkan sort option
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    if ($sort == "terbaru") {
        $query .= " ORDER BY tanggal DESC";
    } elseif ($sort == "terlama") {
        $query .= " ORDER BY tanggal ASC";
    }
}

$result = mysqli_query($koneksi, $query);

if ($result === false) {
    die("Kueri SQL gagal dieksekusi: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-bordered">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';

    $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    while ($row = mysqli_fetch_assoc($result)) {
        $tanggal_bahasa_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));

        echo '<tr>';
        echo '<td>' . $tanggal_bahasa_indonesia . '</td>';
        echo '<td>' . $row['tempat_kunjungan'] . '</td>';
        echo '<td>' . $row['alamat'] . '</td>';
        echo '<td>' . $row['kecamatan'] . '</td>';
        echo '<td>' . $row['kontak'] . '</td>';
        echo '<td>' . $row['jumlah_siswa'] . '</td>';
        echo '<td>' . $row['petugas_layanan'] . '</td>';

        // Tentukan kelas status berdasarkan nilai status
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

        // Tambahkan tombol aksi (delete dan edit)
        echo '<td>';
        echo '<div class="btn-group">';
        echo '<a href="kunjungan.php?id=' . htmlspecialchars($row['id']) . '"><button class="delete"><p><i class="bx bxs-trash-alt"></i> Delete</p></button></a>';
        echo '<a href=" action/edit_kunjungan.php?id=' . htmlspecialchars($row['id']) . '"><button class="edit"><p><i class="bx bxs-edit-alt"></i> Edit</p></button></a>';
        echo '</div>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<p>Tidak ada Data Kunjungan yang ditemukan.</p>';
}
?>
