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
	<!-- Sweetalert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- My CSS -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/responsive.css">
	<title>Pusling</title>
</head>

<?php
session_start();
require('database.php');
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
			<li class="active">
				<a href="/">
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
			<li>
				<a href="kunjungan.php">
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
			<!-- <a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a> -->
			<!-- <a href="#" class="profile">
				<img src="img/people.png">
			</a> -->
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Beranda</h1>
					<ul class="breadcrumb">
						<!-- <li>
							<a href="#">Data Kunjungan</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Beranda</a>
						</li> -->
					</ul>
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
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<script src="script/script.js"></script>
	<?php
	if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
		echo '<script>
				Swal.fire({
					title: "Selamat Datang",
					text: "Anda Berhasil Login",
					icon: "success",
				});
			</script>';
		unset($_SESSION['login']);
	} ?>
</body>

</html>