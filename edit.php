<?php
session_start();
require "database.php";


//Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id_peserta
if (isset($_GET['id'])) {
$id = htmlspecialchars($_GET['id']);
$query = "SELECT * FROM kunjungan WHERE id = $id";
$result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    $_SESSION['error'] = "Data tidak ditemukan";
    // header("Location: index.php");
    // exit();
}
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST['id']);
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $tempat_kunjungan = htmlspecialchars($_POST['tempat']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $kecamatan = htmlspecialchars($_POST['kecamatan']);
    $status = htmlspecialchars($_POST['status']);

    // Query untuk update data
    $query = "UPDATE kunjungan SET tanggal = '$tanggal', tempat_kunjungan = '$tempat_kunjungan', alamat = '$alamat', kecamatan = '$kecamatan', status = '$status' WHERE id = $id";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Data berhasil disimpan";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Data gagal disimpan";
        header("Location: index.php");
    }
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Boxicons -->
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">    
    <title>Edit Data Kunjungan</title>
</head>
<body>

 <!-- SIDEBAR -->
 <section id="sidebar">

<a href="#" class="brand">
    <i class='bx bxs-truck' ></i>
    <span class="text">Pusling</span>
</a>
<ul class="side-menu top">
    <li>
        <a href="beranda.php">
            <i class='bx bxs-dashboard' ></i>
            <span class="text">Beranda</span>
        </a>
    </li>
    <li>
        <a href="jadwal.php">
            <i class='bx bxs-calendar'></i>
            <span class="text">Jadwal Kunjungan</span>
        </a>
    </li>
    <li class="active">
        <a href="kunjungan.php">
            <i class='bx bxs-truck'></i>
            <span class="text">Kunjungan</span>
        </a>
    </li>
</ul>
<ul class="side-menu">
    <li>
        <a href="pengaturan.php">
            <i class='bx bxs-cog' ></i>
            <span class="text">Pengaturan</span>
        </a>
    </li>
    <li>
        <a href="index.php" class="logout">
            <i class='bx bxs-log-out-circle' ></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>
</section>
<!-- SIDEBAR -->



<!-- CONTENT -->
<section id="content">
<!-- NAVBAR -->
<nav>
    <i class='bx bx-menu' ></i>
    <input type="checkbox" id="switch-mode" hidden>
    <label for="switch-mode" class="switch-mode"></label>
</nav>
<!-- NAVBAR -->

<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Edit data</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="kunjungan.php">Kunjungan</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Edit Data</a>
                </li>
            </ul>
        </div>
    </div>

    <section id="edit-data">
        <div class="container">
            <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" novalidate>
            <?php if(isset($errors['update'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errors['update']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tempat" class="form-label">Tempat Kunjungan</label>
                    <input type="text" class="form-control" id="tempat" name="tempat" value="<?php echo $row['tempat_kunjungan']; ?>" required>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required><?php echo $row['alamat']; ?></textarea>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $row['kecamatan']; ?>" required>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="">Pilih status</option>
                        <option value="Belum Di kunjungi">Belum Di kunjungi</option>
                        <option value="Sudah Dikunjungi">Sudah Dikunjungi</option>
                        <option value="Batal Dikunjungi">Batal Dikunjungi</option>
                    </select>
                    <div class="invalid-feedback">
                        Tolong pilih status kunjungan
                    </div>
                </div>
                <button id="submitBtn" type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </section>


</main>
<!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="script/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('submitBtn').addEventListener('click', function (event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Anda Yakin Ingin Mengubah Data ini?',
                text: 'Data akan diubah secara otomatis',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya Ubah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let forms = document.querySelectorAll('.needs-validation');
                    let validation = true;

                    Array.prototype.slice.call(forms).forEach(function (form) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');
                            validation = false;
                        }
                    });

                    if (validation) {
                        document.querySelector('.needs-validation').submit();
                    } else {
                        Swal.fire('Ada kesalahan pada inputan.', 'Tolong isi semua kolom dengan benar.', 'error');
                    }
                } else {
                    Swal.fire('Perubahan Data Dibatalkan', '', 'info');
                }
            });
        });
    });
</script>


</body>
</html>
