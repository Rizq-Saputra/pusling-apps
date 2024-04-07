<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- SweetAlert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
			<li>
				<a href="beranda.php">
					<i class='bx bxs-dashboard'></i>
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
					<h1>Jadwal Kunjungan</h1>
				</div>
			</div>

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

					// Handle status update
					if (isset($_POST["place_id"])) {
						$place_id = $_POST["place_id"];
						$place_id = mysqli_real_escape_string($koneksi, $place_id);
						echo "<script>
							Swal.fire({
								title: 'Anda yakin mengubah status ke Sudah Dikunjungi ?',
								text: 'Data akan tersimpan otomatis.',
								icon: 'question',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ya, Ubah Status!'
							}).then((result) => {
								if (result.isConfirmed) {
									// Redirect to delete script with ID parameter
									window.location.href = 'action/update_status.php?id=$place_id';
									
								}
							});
						</script>";
					}
				}

				$query = "SELECT tanggal, alamat, tempat_kunjungan, status, id FROM kunjungan WHERE tanggal = '$selectedDate'";
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
								$class_text = "belum";
								break;
							case "Sudah Dikunjungi":
								$status_class = "completed";
								$class_text = "sudah";
								break;
							default:
								$status_class = "";
								$icon_class = "";
								break;
						}
						$nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
						$tanggal_indonesia = $nama_hari[date('w', strtotime($row['tanggal']))] . ' ' . date('j F Y', strtotime($row['tanggal']));
						$tempat_kunjungan .= '<p>';
						$tempat_kunjungan .= '<li class="' . $status_class . '">';
						$tempat_kunjungan .= '<div class="text">';
						$status = '<p class = "' . $class_text . '" >' . $row['status'] . '</p>';
						$tempat_kunjungan .= $status;
						$tempat_kunjungan .= '<p>' . $row['tempat_kunjungan'] . '</p>';
						$tempat_kunjungan .= '<p class="text-desc">' . $row['alamat'] . '</p>';
						$tempat_kunjungan .= '</div>';
						if (!empty($icon_class)) {
							$tempat_kunjungan .= '<form method="post"><input type="hidden" name="place_id" value="' . $row['id'] . '"><button type="submit" class="update-status-button"><i class="' . $icon_class . '"></i></button></form>';
						}
						$tempat_kunjungan .= '</li>';
						$tempat_kunjungan .= '</p>';
					}
				} else {
					$tempat_kunjungan = '<p><li class="not-completed">Tidak ada tempat kunjungan pada tanggal yang dipilih.</li></p>';
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

			<?php
			$query = "SELECT * FROM kunjungan";

			// Filter berdasarkan pencarian (search)
			if (isset($_GET['search']) && !empty($_GET['search'])) {
				$search = mysqli_real_escape_string($koneksi, $_GET['search']);
				$query .= " WHERE
						tempat_kunjungan LIKE '%$search%' OR
						alamat LIKE '%$search%' OR
						kontak LIKE '%$search%' OR
						petugas_layanan LIKE '%$search%' OR
						status LIKE '%$search%'";
			}

			// Filter berdasarkan tanggal yang dipilih
			if (isset($_POST['selectedDate']) && !empty($_POST['selectedDate'])) {
				$selectedDate = mysqli_real_escape_string($koneksi, $_POST['selectedDate']);
				if (strpos($query, 'WHERE') !== false) {
					$query .= " AND tanggal = '$selectedDate'";
				} else {
					$query .= " WHERE tanggal = '$selectedDate'";
				}
			}

			// Lakukan query ke database
			$result = mysqli_query($koneksi, $query);

			// Periksa hasil query
			if ($result === false) {
				die('Query error: ' . mysqli_error($koneksi));
			}
			?>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<div class="left-head">
							<h3>Jadwal</h3>
						</div>
						<form class="filter" method="GET">
							<div class="form-input">
								<input type="search" name="search" placeholder="Cari..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
								<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
							</div>
						</form>
					</div>
					<table>
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Tempat Kunjungan</th>
								<th>Alamat</th>
								<th>Kontak</th>
								<th>Status</th>
								<th>Petugas Layanan</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
									echo '<tr>';
									echo '<td>' . date('d-m-Y', strtotime($row['tanggal'])) . '</td>';
									echo '<td>' . htmlspecialchars($row['tempat_kunjungan']) . '</td>';
									echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
									echo '<td>' . htmlspecialchars($row['kontak']) . '</td>';
									echo '<td>' . htmlspecialchars($row['status']) . '</td>';
									echo '<td>' . htmlspecialchars($row['petugas_layanan']) . '</td>';
									echo '</tr>';
								}
							} else {
								echo '<tr><td colspan="6">Tidak ada data kunjungan yang sesuai dengan filter.</td></tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>



		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	<script src="script/script.js"></script>
	<script src="script/calendar.js"></script>

	<?php
	include "lib/alert.php";
	?>

</body>

</html>