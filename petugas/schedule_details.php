<?php
require "../database.php";
require_once('../lib/format_date.php');

// Periksa apakah parameter id jadwal ada dalam URL
if (isset($_GET['id'])) {
    // Ambil id jadwal dari URL dan pastikan itu integer
    $scheduleId = intval($_GET['id']);
    // Query untuk mengambil detail jadwal berdasarkan id
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
    <title>Detail Jadwal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
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
                    <h5 class="card-title"><?php echo $schedule['tempat_kunjungan']; ?></h5>
                    <p class="card-text">Tanggal : <?php echo formatDate($schedule['tanggal']); ?></p>
                    <p class="card-text"><strong>Alamat</strong> : <?php echo $schedule['alamat']; ?></p>
                    <p class="card-text"><strong>Kecamatan</strong> : <?php echo $schedule['kecamatan']; ?></p>
                    <p class="card-text"><strong>Status</strong> : <?php echo $schedule['status']; ?></p>
                    <p class="card-text"><strong>Petugas Layanan</strong> : <?php echo $schedule['petugas_layanan']; ?></p>
                    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3">Kembali</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS (diperlukan untuk komponen Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>