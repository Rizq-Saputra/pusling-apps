<?php
function logout($targetLocation = 'index.php')
{
    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: $targetLocation");
        exit();
    }
}

function checkUserRole($allowedRoles, $targetLocation = 'index.php') {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
        echo '<div class="container text-center mt-5">';
        echo '<h2 class="mb-4">Akses Ditolak!</h2>';
        echo '<p>Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>';
        echo '<p>Silakan hubungi administrator untuk informasi lebih lanjut.</p>';
        echo '<a href="' . $targetLocation . '" class="btn btn-primary btn-lg mt-3">Kembali ke Halaman Login</a>';
        echo '</div>';
        exit();
    }
}
