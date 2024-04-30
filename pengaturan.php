<?php
session_start();
require_once "database.php";

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['new_username']);
    $password = htmlspecialchars($_POST['new_password']);
    $role = $_POST['role'];

    // Validasi username
    if (empty($username)) {
        $errors['username'] = "Username harus diisi";
    } else {
        // Periksa apakah username sudah terdaftar
        $stmt = $koneksi->prepare("SELECT username FROM pengguna WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['username'] = "Username sudah terdaftar";
        }
    }

    // Jika tidak ada kesalahan, lakukan penambahan pengguna
    if (count($errors) == 0) {
        // Gunakan prepared statement untuk mencegah SQL Injection
        $stmt = $koneksi->prepare("INSERT INTO pengguna (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Pengguna berhasil ditambahkan";
        } else {
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
	<meta name="description" content="Pusling Aplication">
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
                    <h1>Pengaturan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Pengaturan</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
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
                            <h2>Tambah Pengguna</h2>
                            <?php if (!empty($errors)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php foreach ($errors as $error) : ?>
                                        <p><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <form class="needs-validation" action="pengaturan.php" method="post" novalidate>
                                <?php if (isset($errors['username'])) : ?>
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
                                    <div class="password_input">
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru" required>
                                        <i class="toggle-password bx bxs-low-vision"></i>
                                    </div>
                                    <div class="invalid-feedback">
                                        Tolong isi kolom ini terlebih dahulu
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Jenis Pengguna</label>
                                    <select class="form-select" name="role" id="role">
                                        <option value="admin">Admin</option>
                                        <option value="petugas">Petugas Layanan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Tambah Pengguna</button>
                            </form>
                        </div>
                    </div>

                    <div class="table-data">
                        <div class="order">
                            <div class="head">
                                <div class="left-head">
                                    <h3>Data Pengguna</h3>
                                </div>
                                <form class="filter" method="GET">
                                    <div class="form-input">
                                        <input type="search" name="search" placeholder="Cari..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                        <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                    </div>
                                    <span>
                                        <select name="sort">
                                            <option value="terbaru">Terbaru</option>
                                            <option value="terlama">Terlama</option>
                                        </select>
                                    </span>
                                    <span>
                                        <select name="role">
                                            <option value="semua">Semua</option>
                                            <option value="user">user</option>
                                            <option value="admin">admin</option>
                                        </select>
                                    </span>
                                    <span><button type="submit">Filter <i class='bx bx-filter'></i></button></span>
                                </form>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "database.php";

                                    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'terbaru';
                                    $role = isset($_GET['role']) ? mysqli_real_escape_string($koneksi, $_GET['role']) : 'semua';


                                    $where = '';
                                    if ($search != '') {
                                        $where .= " WHERE username LIKE '%$search%'";
                                    }
                                    if ($role != 'semua') {
                                        if ($where != '') {
                                            $where .= " AND role = '$role'";
                                        } else {
                                            $where .= " WHERE role = '$role'";
                                        }
                                    }

                                    // Sesuaikan query SQL dengan kondisi tambahan
                                    $query = "SELECT * FROM pengguna" . $where;

                                    // Sesuaikan query SQL dengan pengurutan
                                    if ($sort == 'terbaru') {
                                        $query .= " ORDER BY id_pengguna DESC"; // Urutkan berdasarkan id_pengguna dari yang terbaru
                                    } else {
                                        $query .= " ORDER BY id_pengguna ASC"; // Urutkan berdasarkan id_pengguna dari yang terlama
                                    }

                                    $result = mysqli_query($koneksi, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['password'] . "</td>";
                                            echo "<td>" . $row['role'] . "</td>";
                                            echo '<td>';

                                            if (isset($row['id_pengguna'])) {
                                                echo '<div class="btn-group">';
                                                echo '<a href="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $row['id_pengguna'] . '"><button class="delete"><p><i class="bx bxs-trash-alt"></i> Delete</p></button></a>';
                                                echo '<a href="action/edit_pengguna.php?id=' . htmlspecialchars($row['id_pengguna']) . '"><button class="edit"><p><i class="bx bxs-edit-alt"></i> Edit</p></button></a>';
                                                echo '</div>';
                                            } else {
                                                echo "Kunci 'id' tidak tersedia";
                                            }

                                            echo '</td>';
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>Tidak ada data pengguna</td></tr>";
                                    }

                                    mysqli_close($koneksi);
                                    ?>
                                </tbody>
                            </table>
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
        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('new_password');
            const togglePassword = document.querySelector('.toggle-password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('bx-show');
                this.classList.toggle('bxs-low-vision');
            });
        });
    </script>


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
							window.location.href = 'action/hapus_pengguna.php?id=$id';
						}
					});
				</script>";
    }

    include "lib/alert.php";
    ?>

</body>

</html>