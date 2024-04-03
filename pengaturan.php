<?php
session_start();
include "database.php";

$errors = array();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($koneksi, $_POST['new_username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['new_password']);
    $role = $_POST['role'];

    $cari_username = "SELECT username FROM pengguna WHERE username='$username'";
    $validation_username = mysqli_query($koneksi,$cari_username);

    if(mysqli_num_rows($validation_username) > 0){
        $errors['username'] = "Username Sudah Terdaftar";           
    } 
    
    if (count($errors) == 0) {
        $query = "INSERT INTO pengguna (username, password, role) VALUES ('$username', '$password', '$role')";
        if(mysqli_query($koneksi, $query)){
            $_SESSION['success'] = "Pengguna berhasil ditambahkan";
        } else {
            // echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
			echo '<script>
                    Swal.fire({
                        title: "Gagal Menambahkan Pengguna!",
                        text: "Pengguna Gagal ditambahkan",
                        icon: "error",
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false
                    });
                  </script>';
        }
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

    <title>Pusling</title>
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
            <li>
                <a href="kunjungan.php">
                    <i class='bx bxs-truck'></i>
                    <span class="text">Kunjungan</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li class="active">
                <a href="#">
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
                    <h1>Pengaturan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Pengaturan</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Admin</a>
                        </li>
                    </ul>
                </div>
            </div>

            <section id="settings">
                <div class="container">
                    <div class="row">
					<div class="col-md-5">
						<form class="needs-validation" action="pengaturan.php" method="post" novalidate>
							<h2>Tambah Pengguna</h2>
							<?php if(isset($errors['username'])): ?>
								<div class="alert alert-danger" role="alert">
									<?php echo $errors['username']; ?>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php endif; ?>
							<div class="mb-3 form-group">
								<label for="new_username" class="form-label">Username</label>
								<input type="text" class="form-control" id="new_username" name="new_username" placeholder="Masukkan username baru" required>
								<div class="invalid-feedback">
									Tolong isi kolom ini terlebih dahulu
								</div>
							</div>							
							<div class="mb-3 form-group">
								<label for="new_password" class="form-label">Password</label>
								<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru" required>
								<div class="invalid-feedback">
									Tolong isi kolom ini terlebih dahulu
								</div>
							</div>
							<div class="mb-3">
								<label for="role" class="form-label">Jenis Pengguna</label>
								<select class="form-select" name="role" id="role">
									<option value="admin">Admin</option>
									<option value="user">User</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary" name="submit">Tambah Pengguna</button>
						</form>
					</div>
                    </div>
                </div>
            </section>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="script/script.js"></script>
	<script>
        document.addEventListener('DOMContentLoaded', function () {
            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>

	<?php
	if(isset($_SESSION['success'])) {
		echo '<script>
			Swal.fire({
				title: "Sukses!",
				text: "Pengguna berhasil ditambahkan",
				icon: "success",
				timer: 2000,
				timerProgressBar: true,
				showConfirmButton: false
			}).then(function() {
				window.location.href = "pengaturan.php";
			});
		</script>';
		unset($_SESSION['success']);
	}
	?>

</body>
</html>
