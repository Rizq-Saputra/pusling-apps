<?php 

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
			<li class="active">
				<a href="#">
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
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Jadwal Kunjungan</h1>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download Jadwal</span>
				</a>
			</div>

			<!-- <ul class="box-info">
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
			</ul> -->
			<section id="calendar">
				<div class="wrapper">
					<header>
						<p class="current-date"></p>
						<div class="icons">
							<span id="prev" class="material-symbols-rounded"><i class='bx bx-left-arrow-alt'></i></span>
							<span id="next" class="material-symbols-rounded"><i class='bx bx-right-arrow-alt'></i></span>
						</div>
					</header>
					<div class="calendar">
						<ul class="weeks">
							<li>Minggu</li>
							<li>Senin</li>
							<li>Selasa</li>
							<li>Rabu</li>
							<li>Kamis</li>
							<li>Jumat</li>
							<li>Sabtu</li>
						</ul>
						<ul class="days"></ul>
					</div>
				</div>
				
				<?php
				include "database.php";

				$selectedDate = date('Y-m-d');
				$tempat_kunjungan = "";
				$tanggal_indonesia = ""; 

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if (isset($_POST["selectedDate"]) && !empty($_POST["selectedDate"])) {
						$selectedDate = $_POST["selectedDate"];
						$selectedDate = mysqli_real_escape_string($koneksi, $selectedDate);
					}
				}

				$query = "SELECT tanggal, tempat_kunjungan, status FROM kunjungan WHERE tanggal = '$selectedDate'";
				$result = mysqli_query($koneksi, $query);

				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						$status_class = "";
						$icon_class = "";

						switch ($row['status']) {
							case "Belum Di kunjungi":
							case "Batal Dikunjungi":
								$status_class = "not-completed";
								$icon_class = "bx bxs-check-circle";
								break;
							case "Sudah Dikunjungi":
								$status_class = "completed";
								break;
							default:
								$status_class = "";
								$icon_class = "";
								break;
						}

						$tempat_kunjungan .= '<li class="' . $status_class . '">';
						$tempat_kunjungan .= '<p>' . $row['tempat_kunjungan'] . '</p>';

						$nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
						$tanggal_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));
						if (!empty($icon_class)) {
							$tempat_kunjungan .= '<i class="' . $icon_class . '"></i>';
						}
						$tempat_kunjungan .= '</li>';
					}
				} else {
					$tempat_kunjungan = '<li class="not-completed">Tidak ada tempat kunjungan pada tanggal yang dipilih.</li>';
				}
				?>


				<div class="wrapper">
					<div class="container-todo">
						<div class="todo">
							<div class="head">
								<h3>Jadwal</h3>
								<form class="d-block" method="POST">
									<div>
										<label for="inputDate" class="form-label">Pilih Tanggal</label>
										<input type="date" class="form-control" id="inputDate" name="selectedDate" value="<?= isset($_POST["selectedDate"]) ? $_POST["selectedDate"] : date('Y-m-d') ?>">
									</div>
									<div>
										<button type="submit" class="btn btn-primary">Lihat</button>
									</div>
								</form>
							</div>
							<ul class="todo-list">
								<p><?= $tanggal_indonesia ?></p> 
								<p><?= $tempat_kunjungan ?></p>
							</ul>
						</div>
					</div>
				</div>
			</section>

			<!-- <div class="table-data">
				<div class="order">
					<div class="head">
						<div class="left-head">
							<h3>Jadwal Kunjungan</h3>
						</div>
						<form action="#">
							<div class="form-input">
								<input type="search" placeholder="Cari...">
								<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
							</div>
						</form>
						<div class="right-head">
							<form class="filter">
								<span>
									<select>
										<option value="all">Terbaru</option>
										<option value="all">Terlama</option>
									</select>
								</span>
								<span>
									<select>
										<option value="all">Status</option>
										<option value="all">Selesai</option>
										<option value="all">Belum Selesai</option>
									</select>
								</span>
								<span><button>Filter <i class='bx bx-filter' ></i></button></span>
							</form>
                        </div>
					</div>
					<table>
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Jam</th>
								<th>Sekolah</th>
								<th>Alamat Sekolah</th>
								<th>Nomor Hp</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>01-10-2024</td>
								<td>05:40</td>
                                <td>smk negeri 1</td>
                                <td class="alamat">jl. KH Wahid Hasyim 2 Rt 06 No 21 Samping sungai Keledang</td>
                                <td>0822222222</td>
								<td><span class="status completed">Selesai</span></td>
							</tr>
							<tr>
								<td>01-10-2024</td>
								<td>05:40</td>
                                <td>smk negeri 1</td>
                                <td class="alamat">jl. KH Wahid Hasyim 2 Rt 06 No 21 Samping sungai Keledang</td>
                                <td>0822222222</td>
								<td><span class="status process">Dalam Proses</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div> -->
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script/script.js"></script>
	<script src="script/calendar.js"></script>
</body>
</html>