<?php
session_start();
require "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM pengguna WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['login'] = true;

        // Redirect based on user role
        if ($user['role'] == 'petugas') {
            $_SESSION['role'] = 'petugas';
            header("location: petugas/home.php");
            exit();
        } elseif ($user['role'] == 'admin') {
            $_SESSION['role'] = 'admin';
            header("location: beranda.php");
            exit();
        } else {
            // Handle other roles as needed
            header("location: default_home.php");
            exit();
        }
    } else {
        $login_error = "Username atau password salah.";
    }
}
?>

<?php

require "database.php";

// Fungsi untuk menambahkan akun admin cadangan
function tambahAkunAdminCadangan($koneksi, $username, $password)
{
    $query = "INSERT INTO pengguna (username, password, role) VALUES ('$username', '$password', 'admin')";

    if (mysqli_query($koneksi, $query)) {
        return true;
    } else {
        return false;
    }
}

$query = "SELECT COUNT(*) as count_admin FROM pengguna WHERE role='admin'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
$countAdmin = $row['count_admin'];

if ($countAdmin == 0) {

    $username = "admin";
    $password = "password";

    if (tambahAkunAdminCadangan($koneksi, $username, $password)) {
        return;
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
    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <i class='bx bxs-truck'></i><span class="text">Pusling</span>
            </div>
            <h2 class="text-center">Login</h2>
            <form id="login-form" class="needs-validation" action="index.php" method="post" novalidate>
                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <div class="form-group">
                    <div class="password-input">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        <i class="toggle-password bx bxs-low-vision"></i>
                    </div>
                    <div class="invalid-feedback">
                        Tolong isi kolom ini terlebih dahulu
                    </div>
                </div>
                <?php if (isset($login_error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $login_error; ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-login">Login</button>
            </form>
        </div>
    </div>

    <script src="script/login.js"></script>
</body>

</html>