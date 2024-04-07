<?php
session_start();
require "../database.php";

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit();
  }

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    
    $query = "SELECT * FROM pengguna WHERE id_pengguna = $id";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "Data tidak ditemukan";
        header("Location: ../pengaturan.php");
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST['id_pengguna']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $role = $_POST['role'];

    $query = "UPDATE pengguna SET username = '$username', password = '$password', role = '$role' WHERE id_pengguna = $id";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Data berhasil diubah";
        header("Location: ../pengaturan.php");
        exit();
    } else {
        $_SESSION['error'] = "Data gagal diubah";
        header("Location: ../pengaturan.php");
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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">    
    <title>Edit Data Pengguna</title>
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
        <a href="../beranda.php">
            <i class='bx bxs-dashboard' ></i>
            <span class="text">Beranda</span>
        </a>
    </li>
    <li>
        <a href="../jadwal.php">
            <i class='bx bxs-calendar'></i>
            <span class="text">Jadwal Kunjungan</span>
        </a>
    </li>
    <li>
        <a href="../kunjungan.php">
            <i class='bx bxs-truck'></i>
            <span class="text">Kunjungan</span>
        </a>
    </li>
</ul>
<ul class="side-menu">
    <li class="active">
        <a href="../pengaturan.php">
            <i class='bx bxs-cog' ></i>
            <span class="text">Pengaturan</span>
        </a>
    </li>
    <li>
        <a href="?logout=true" class="logout">
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
                    <a href="../pengaturan.php">Pengaturan</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Edit Data</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="edit-data" id="edit-data">
        <div class="container">
            <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate>
                <input type="hidden" name="id_pengguna" value="<?php echo $row['id_pengguna']; ?>">
                <?php if(isset($errors['username'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['username']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="mb-3 form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username baru" value="<?php echo $row['username']; ?>" required>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>							
                <div class="mb-3 form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password_input">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru" value="<?php echo $row['password']; ?>" required>
                        <i class="toggle-password bx bxs-low-vision"></i>
                    </div>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Jenis Pengguna</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="admin" <?php echo ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="petugas" <?php echo ($row['role'] == 'petugas') ? 'selected' : ''; ?>>Petugas Layanan</option>
                    </select>
                    <div class="invalid-feedback">
                        Tolong pilih status kunjungan.
                    </div>
                </div>
                <button type="submit" id="submitBtn" class="btn btn-primary">Simpan Perubahan</button>
            </form>
                
        </div>
    </section>


</main>
<!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../script/script.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const passwordInput = document.getElementById('password');
        const togglePassword = document.querySelector('.toggle-password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bx-show');
            this.classList.toggle('bxs-low-vision');
        });

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
                    header("Location: ../pengaturan.php");
                }
            });
        });
    });
</script>


</body>
</html>
