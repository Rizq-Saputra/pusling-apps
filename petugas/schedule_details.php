<?php
require "../database.php";
require_once('../lib/format_date.php');

if (isset($_GET['id'])) {
    $scheduleId = intval($_GET['id']);
    $query = "SELECT * FROM kunjungan WHERE id = $scheduleId";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $schedule = mysqli_fetch_assoc($result);
    } else {
        $errorMessage = "Jadwal tidak ditemukan.";
    }
} else {
    $errorMessage = "Parameter id tidak ditemukan dalam URL.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pusling Aplication">
    <title>Detail Jadwal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #007bff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        p {
            margin-bottom: 5px;
        }
    </style>
</head>
<?php
session_start();
require_once('../lib/logout.php');
checkUserRole(['petugas'], '../index.php');
?>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Detail Jadwal</h1>
        <div class="card">
            <div class="card-body">
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php else : ?>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Tempat Kunjungan</th>
                                <td><?php echo $schedule['tempat_kunjungan']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal</th>
                                <td><?php echo formatDate($schedule['tanggal']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat</th>
                                <td><i class="fas fa-map-marker-alt"></i> <?php echo $schedule['alamat']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kecamatan</th>
                                <td> <?php echo $schedule['kecamatan']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kontak</th>
                                <td><i class="fas fa-phone"></i> <?php echo $schedule['kontak']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah Siswa</th>
                                <td><i class="fas fa-users"></i> <?php echo $schedule['jumlah_siswa']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><i class="fas fa-check-circle <?php echo ($schedule['status'] === 'Sudah Dikunjungi') ? 'text-success' : 'text-danger'; ?>"></i> <?php echo $schedule['status']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Petugas Layanan</th>
                                <td><i class="fas fa-user"></i> <?php echo $schedule['petugas_layanan']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>