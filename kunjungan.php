<?php
session_start();
include "database.php";

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
  }

  
//   Menambahkan data kunjungan
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $tanggal = $_POST['tanggal'];
    $tempat_kunjungan = $_POST['tempat'];
    $alamat = $_POST['alamat'];
    $kecamatan = $_POST['kecamatan'];
	$status = "Belum Di kunjungi";

    // Validasi data
    if (empty($tanggal) || empty($tempat_kunjungan) || empty($alamat) || empty($kecamatan)) {
		$_SESSION['error'] = "Data Gagal ditambahkan";
        $error_message = "Mohon lengkapi semua kolom.";
    } else {
        $query = "INSERT INTO kunjungan (tanggal, tempat_kunjungan, alamat, kecamatan, status) 
                  VALUES ('$tanggal', '$tempat_kunjungan', '$alamat', '$kecamatan', '$status')";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Data berhasil ditambahkan";
        } else {
            $_SESSION['error'] = "Data Gagal ditambahkan";
            $error_message = "Terjadi kesalahan. Silakan coba lagi.";
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
	<!-- bootstrap -->
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
			<li class="active">
				<a href="#">
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
					<h1>Kunjungan</h1>
				</div>
				<div class="download">
					<a href="#" class="btn-download">
						<i class='bx bxs-cloud-download' ></i>
						<span class="text">Download Excel</span>
					</a>
					<a href="#" class="btn-download">
						<i class='bx bxs-cloud-download' ></i>
						<span class="text">Download PDF</span>
					</a>
				</div>
			</div>

			<ul class="box-info">
			<?php
			// Query untuk menghitung jumlah total kunjungan
			$query_total = "SELECT COUNT(*) AS total_kunjungan FROM kunjungan";
			$result_total = mysqli_query($koneksi, $query_total);

			if ($result_total) {
				$row_total = mysqli_fetch_assoc($result_total);
				$total_kunjungan = $row_total['total_kunjungan'];
			} else {
				$total_kunjungan = "Error";
			}
			?>
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3><?php echo $total_kunjungan; ?></h3>
						<p>Total Kunjungan</p>
					</span>
				</li>

				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3><?php echo $total_kunjungan; ?></h3>
						<p>Jumlah Kunjungan</p>
					</span>
				</li>
				<li>
					<i class='bx bx-history' ></i>
					<span class="text">
						<h3><?php echo $total_kunjungan; ?></h3>
						<p>Riwayat Kunjungan</p>
					</span>
				</li>
			</ul>

            <section id="popup">
                <div class="popup-box">
                    <div class="popup">
                        <div class="content">
                            <header>
                                <p></p>
                                <i class='bx bx-x'></i>
                            </header>
							<form class="needs-validation" action="" method="post" novalidate>
							<input type="hidden" name="action" value="add">
							<?php if(isset($error_message)): ?>
								<div class="alert alert-danger" role="alert">
									<?php echo $error_message; ?>
								</div>
							<?php endif; ?>
							<?php if(isset($success_message)): ?>
								<div class="alert alert-success" role="alert">
									<?php echo $success_message; ?>
								</div>
							<?php endif; ?>
								<div class="row form-group">
									<label for="tanggal">Tanggal</label>
									<input type="date" id="tanggal" name="tanggal" required>
									<div class="invalid-feedback">
										Tolong isi kolom ini terlebih dahulu
									</div>
								</div>								
								<div class="row form-group">
									<label for="tempat">Tempat Kunjungan</label>
									<input type="text" id="tempat" name="tempat" class="form-control" required>
									<div class="invalid-feedback">
										Tolong isi kolom ini terlebih dahulu
									</div>
								</div>
								<div class="row form-group">
									<label for="kecamatan">Kecamatan</label>
									<input type="text" id="kecamatan" name="kecamatan" class="form-control" required>
									<div class="invalid-feedback">
										Tolong isi kolom ini terlebih dahulu
									</div>
								</div>
								<div class="row description form-group">
									<label for="alamat">Alamat</label>
									<textarea id="alamat" class="form-control" name="alamat" required spellcheck="false"></textarea>
									<div class="invalid-feedback">
										Tolong isi kolom ini terlebih dahulu
									</div>
								</div>  
								<!-- <div class="row form-group">
									<label for="nomor-hp">Nomor Hp</label>
									<input type="text" id="nomor-hp" class="form-control" required pattern="[0-9\+\-\(\)\s]+" title="Masukkan Angka" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Masukkan Angka')">
									<div class="invalid-feedback">
										Tolong isi kolom ini terlebih dahulu
									</div>
								</div>           -->                   
								<div class="row">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
                        </div>
                    </div>
                </div>                
            </section>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<div class="left-head">
							<h3>Data Kunjungan</h3>
							<div class="add-element">
								<button class="add-data"><p>+ Tambah Data</p></button>
							</div>
						</div>
						<form class="filter" method="GET">
							<div class="form-input">
								<input type="search" name="search" placeholder="Cari..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
								<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
							</div>
							<span>
								<select name="sort">
									<option value="terbaru">Terbaru</option>
									<option value="terlama">Terlama</option>
								</select>
							</span>
							<span>
								<select name="status">
									<option value="semua">Semua</option>
									<option value="Belum Di kunjungi">Belum Di kunjungi</option>
									<option value="Sudah Dikunjungi">Sudah Dikunjungi</option>
									<option value="Batal Dikunjungi">Batal Dikunjungi</option>
								</select>
							</span>
							<span><button type="submit">Filter <i class='bx bx-filter'></i></button></span>
						</form>
					</div>
					
					<?php
					include "database.php";

					$query = "SELECT * FROM kunjungan WHERE 1";

					if(isset($_GET['status']) && $_GET['status'] !== "semua") {
						$status = $_GET['status'];
						$query .= " AND status = '" . mysqli_real_escape_string($koneksi, $status) . "'";
					}

					if(isset($_GET['search'])) {
						$search = $_GET['search'];
						$query .= " AND (tempat_kunjungan LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%' OR alamat LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%' OR kecamatan LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%')";
					}

					if(isset($_GET['sort'])) {
						$sort = $_GET['sort'];
						if($sort == "terbaru") {
							$query .= " ORDER BY tanggal DESC";
						} elseif($sort == "terlama") {
							$query .= " ORDER BY tanggal ASC";
						}
					}

					$result = mysqli_query($koneksi, $query);

					if(mysqli_num_rows($result) > 0) {
						echo '<table class="table table-bordered">
								<thead>
									<tr>
										<th>Tanggal</th>
										<th>Tempat Kunjungan</th>
										<th>Alamat</th>
										<th>Kecamatan</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>';

						$nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
						// Loop melalui setiap baris data
						while($row = mysqli_fetch_assoc($result)) {
							// Menggunakan tanggal dalam bahasa Indonesia
							$tanggal_bahasa_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));

							echo '<tr>';
							// Menggunakan tanggal dalam bahasa Indonesia
							echo '<td>' . $tanggal_bahasa_indonesia . '</td>';
							echo '<td>' . $row['tempat_kunjungan'] . '</td>';
							echo '<td>' . $row['alamat'] . '</td>';
							echo '<td>' . $row['kecamatan'] . '</td>';
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
							echo '<td>';
							echo '<div class="btn-group">';
							echo '<a href="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $row['id'] . '"><button class="delete"><p><i class="bx bxs-trash-alt"></i> Delete</p></button></a>';
							echo '<a href="edit.php?id=' . htmlspecialchars($row['id']) . '"><button class="edit"><p><i class="bx bxs-edit-alt"></i> Edit</p></button></a>';
							echo '</div>';
							echo '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
					} else {
						echo '<p>Tidak ada Data Kunjungan yang ditemukan.</p>';
					}
					?>


				</div>
			</div>
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script/script.js"></script>
	<script src="script/popup.js"></script>
	<!-- <script src="script/crud.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
        // Script to add 'was-validated' class after form submission attempt
        document.addEventListener('DOMContentLoaded', function () {
            let forms = document.querySelectorAll('.needs-validation');

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

// Menghapus data kunjungan
if (isset($_GET['id']))  {
    $id = htmlspecialchars($_GET["id"]);

    // SweetAlert confirmation dialog
    echo "<script>
            Swal.fire({
                title: 'Anda Yakin Ingin Menghapus Data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete script with ID parameter
                    window.location.href = 'delete.php?id=$id';
                }
            });
         </script>";
}


if(isset($_SESSION['success'])) {
    $pesan = $_SESSION['success'];
    echo '<script>
            Swal.fire({
                title: "Sukses!",
                text: "'. $pesan .'",
                icon: "success",                
            });
          </script>';
    unset($_SESSION['success']);
} 
elseif(isset($_SESSION['error'])) {
    $pesan = $_SESSION['error'];
	echo '<script>
		Swal.fire({
			title: "Gagal!",
			text: "'. $pesan .'",
			icon: "error",				
		});
	</script>';
	unset($_SESSION['error']);
}


?>
</body>
</html>