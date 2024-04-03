<?php
session_start();
require "database.php";

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
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
	<!-- Sweetalert -->
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
			<li class="active">
				<a href="/">
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
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>10</h3>
						<p>Total Kunjungan</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>2834</h3>
						<p>Pengunjung</p>
					</span>
				</li>
				<li>
					<i class='bx bx-history' ></i>
					<span class="text">
						<h3>100</h3>
						<p>Riwayat Kunjungan </p>
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
	}?>
</body>
</html>