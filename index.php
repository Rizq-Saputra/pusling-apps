<?php
session_start();
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM pengguna WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['login'] = true; // Set login session variable
        header("location: beranda.php");
        exit();
    } else {
        $login_error = "Username atau password salah.";
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
                <?php if(isset($login_error)): ?>
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
