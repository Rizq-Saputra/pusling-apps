<?php
session_start();
require "database.php";

//   Menambahkan data kunjungan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
	$tanggal = $_POST['tanggal'];
	$tempat_kunjungan = $_POST['tempat'];
	$alamat = $_POST['alamat'];
	$kecamatan = $_POST['kecamatan'];
	$kontak = $_POST['kontak'];
	$jumlah_siswa = $_POST['jumlah_siswa'];
	$petugas = $_POST['petugas'];
	$status = "Belum Di kunjungi";

	// Validasi data
	if (empty($tanggal) || empty($tempat_kunjungan) || empty($alamat) || empty($kecamatan) || empty($kontak)) {
		$_SESSION['error'] = "Data Gagal ditambahkan";
		$error_message = "Mohon lengkapi semua kolom.";
	} else {
		$query = "INSERT INTO kunjungan (tanggal, tempat_kunjungan, alamat, kecamatan, status, kontak, jumlah_siswa, petugas_layanan) 
                  VALUES ('$tanggal', '$tempat_kunjungan', '$alamat', '$kecamatan', '$status', '$kontak', $jumlah_siswa ,'$petugas')";

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
	<meta name="description" content="Pusling Aplication">
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

<?php
require('lib/logout.php');
logout();
checkUserRole(['admin']);
?>

<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-truck'></i>
			<span class="text">Pusling</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="beranda.php">
					<i class='bx bxs-dashboard'></i>
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
					<i class='bx bxs-cog'></i>
					<span class="text">Pengaturan</span>
				</a>
			</li>
			<li>
				<a href="?logout=true" class="logout">
					<i class='bx bxs-log-out-circle'></i>
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
			<i class='bx bx-menu'></i>
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
					<a href="action/laporan.php" class="btn-download">
						<i class='bx bxs-cloud-download'></i>
						<span class="text">Download Data Kunjungan</span>
					</a>
				</div>
			</div>

			<ul class="box-info">
				<?php
				$query_total = "SELECT COUNT(*) AS total_kunjungan FROM kunjungan";
				$result_total = mysqli_query($koneksi, $query_total);

				if ($result_total) {
					$row_total = mysqli_fetch_assoc($result_total);
					$total_kunjungan = $row_total['total_kunjungan'];
				} else {
					$total_kunjungan = 0;
				}
				// Query untuk menghitung jumlah kunjungan dengan status "Belum Di kunjungi"
				$query_belum_dikunjungi = "SELECT COUNT(*) AS belum_dikunjungi FROM kunjungan WHERE status = 'Belum Di kunjungi'";
				$result_belum_dikunjungi = mysqli_query($koneksi, $query_belum_dikunjungi);
				$jumlah_belum_dikunjungi = 0;

				if ($result_belum_dikunjungi) {
					$row_belum_dikunjungi = mysqli_fetch_assoc($result_belum_dikunjungi);
					$jumlah_belum_dikunjungi = $row_belum_dikunjungi['belum_dikunjungi'];
				}

				// Query untuk menghitung jumlah kunjungan dengan status "Sudah Dikunjungi"
				$query_riwayat_kunjungan = "SELECT COUNT(*) AS riwayat_kunjungan FROM kunjungan WHERE status = 'Sudah Dikunjungi'";
				$result_riwayat_kunjungan = mysqli_query($koneksi, $query_riwayat_kunjungan);
				$jumlah_riwayat_kunjungan = 0;

				if ($result_riwayat_kunjungan) {
					$row_riwayat_kunjungan = mysqli_fetch_assoc($result_riwayat_kunjungan);
					$jumlah_riwayat_kunjungan = $row_riwayat_kunjungan['riwayat_kunjungan'];
				}
				?>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3><?php echo $total_kunjungan; ?></h3>
						<p>Total Kunjungan</p>
					</span>
				</li>

				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3><?php echo $jumlah_riwayat_kunjungan; ?></h3>
						<p>Riwayat Kunjungan</p>
					</span>
				</li>
				<li>
					<i class='bx bx-history'></i>
					<span class="text">
						<h3><?php echo $jumlah_belum_dikunjungi; ?></h3>
						<p>Belum Dikunjungi</p>
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
								<?php if (isset($error_message)) : ?>
									<div class="alert alert-danger" role="alert">
										<?php echo $error_message; ?>
									</div>
								<?php endif; ?>
								<?php if (isset($success_message)) : ?>
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
								<div class="row form-group">
									<label for="kontak">Kontak</label>
									<input type="text" id="kontak" name="kontak" class="form-control" required spellcheck="false" pattern="[0-9]+" title="Hanya boleh angka (0-9) saja">
									<div class="invalid-feedback">
										Masukkan hanya angka (0-9) untuk kontak
									</div>
								</div>
								<div class="row form-group">
									<label for="Jumlah Siswa">Jumlah Siswa</label>
									<input type="text" id="jumlah_siswa" name="jumlah_siswa" class="form-control" required spellcheck="false" pattern="[0-9]+" title="Hanya boleh angka (0-9) saja">
									<div class="invalid-feedback">
										Masukkan hanya angka (0-9) untuk Jumlah Siswa
									</div>
								</div>
								<div class="row form-group">
									<label for="petugas">Petugas Layanan</label>
									<input type="text" id="petugas" name="petugas" class="form-control">
								</div>
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
								<button class="add-data">
									<p>+ Tambah Jadwal</p>
								</button>
							</div>
						</div>
						<form class="filter" method="GET">
							<div class="form-input">
								<input type="search" name="search" placeholder="Cari..." id="keyword" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
								<button type="submit" class="search-btn" id="tombol-cari"><i class='bx bx-search'></i></button>
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
					<div id="container_table">
						<?php
						include "database.php";

						$query = "SELECT * FROM kunjungan WHERE 1";

						if (isset($_GET['status']) && $_GET['status'] !== "semua") {
							$status = $_GET['status'];
							$query .= " AND status = '" . mysqli_real_escape_string($koneksi, $status) . "'";
						}

						// Menambahkan pencarian berdasarkan input 'search'
						if (isset($_GET['search'])) {
							$search = $_GET['search'];
							$escaped_search = mysqli_real_escape_string($koneksi, $search);
							// Menambahkan kondisi pencarian ke setiap kolom yang ingin dicari
							$query .= " AND (
							tempat_kunjungan LIKE '%$escaped_search%' OR
							alamat LIKE '%$escaped_search%' OR
							kecamatan LIKE '%$escaped_search%' OR
							kontak LIKE '%$escaped_search%' OR
							petugas_layanan LIKE '%$escaped_search%' OR
							status LIKE '%$escaped_search%'
						)";
						}

						if (isset($_GET['sort'])) {
							$sort = $_GET['sort'];
							if ($sort == "terbaru") {
								$query .= " ORDER BY tanggal DESC";
							} elseif ($sort == "terlama") {
								$query .= " ORDER BY tanggal ASC";
							}
						}

						$result = mysqli_query($koneksi, $query);

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
							// Loop melalui setiap baris data
							while ($row = mysqli_fetch_assoc($result)) {
								// Menggunakan tanggal dalam bahasa Indonesia
								$tanggal_bahasa_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));

								echo '<tr>';
								// Menggunakan tanggal dalam bahasa Indonesia
								echo '<td>' . $tanggal_bahasa_indonesia . '</td>';
								echo '<td>' . $row['tempat_kunjungan'] . '</td>';
								echo '<td>' . $row['alamat'] . '</td>';
								echo '<td>' . $row['kecamatan'] . '</td>';
								echo '<td>' . $row['kontak'] . '</td>';
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
								echo '<td>';
								echo '<div class="btn-group">';
								echo '<a href="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $row['id'] . '"><button class="delete"><p><i class="bx bxs-trash-alt"></i> Delete</p></button></a>';
								echo '<a href="action/edit_kunjungan.php?id=' . htmlspecialchars($row['id']) . '"><button class="edit"><p><i class="bx bxs-edit-alt"></i> Edit</p></button></a>';
								echo '</div>';
								echo '</td>';
								echo '</tr>';
							}
							echo '</tbody>
							</table>
						';
						} else {
							echo '<p>Tidak ada Data Kunjungan yang ditemukan.</p>';
						}
						?>

					</div>
				</div>
			</div>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	<script src="script/script.js"></script>
	<script src="script/popup.js"></script>
	<script src="script/validation.js"></script>
	<script src="script/ajax.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<?php

	// Menghapus data kunjungan
	if (isset($_GET['id'])) {
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
						confirmButtonText: 'Ya Hapus!'
					}).then((result) => {
						if (result.isConfirmed) {
							// Redirect to delete script with ID parameter
							window.location.href = 'action/hapus_kunjungan.php?id=$id';
						}
					});
				</script>";
	}

	include "lib/alert.php";
	?>
</body>

</html>