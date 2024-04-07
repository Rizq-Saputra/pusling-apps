<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Petugas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php
session_start();
require_once('../lib/logout.php');
logout('../index.php');
checkUserRole(['petugas'], '../index.php');
?>

<body>



    <div class="container mt-5">
        <h1 class="mb-4">Jadwal Petugas</h1>
        <a href="?logout=true"><button id="logoutBtn" class="btn btn-primary" style="margin: 20px 0px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button></a>
        <div id="scheduleList">
        </div>
    </div>

    <!-- jQuery (diperlukan untuk AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle JS (diperlukan untuk komponen Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Ambil data jadwal petugas dari server saat halaman dimuat
            $.ajax({
                url: 'get_schedule.php', // Ganti dengan URL yang sesuai untuk mengambil data jadwal dari server
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Memuat daftar jadwal ke dalam div #scheduleList
                    if (response && response.length > 0) {
                        var scheduleListHTML = '<div class="row">';
                        $.each(response, function(index, schedule) {
                            // Mengubah format tanggal ke "Jumat, 5 April 2024"
                            var formattedDate = formatDate(schedule.tanggal);

                            scheduleListHTML += '<div class="col-md-6 mb-4">';
                            scheduleListHTML += '<div class="card">';
                            scheduleListHTML += '<div class="card-body">';
                            scheduleListHTML += '<h5 class="card-title">' + schedule.tempat_kunjungan + '</h5>';
                            scheduleListHTML += '<p class="card-text"><strong>Tanggal :</strong> ' + formattedDate + '</p>'; // Menggunakan tanggal yang diformat
                            scheduleListHTML += '<p class="card-text"><strong>Kecamatan :</strong> ' + schedule.kecamatan + '</p>';
                            scheduleListHTML += '<p class="card-text"><strong>Petugas Layanan :</strong> ' + schedule.petugas_layanan + '</p>';
                            scheduleListHTML += '<button class="btn btn-primary" onclick="viewScheduleDetails(' + schedule.id + ')">Lihat Detail</button>';
                            scheduleListHTML += '</div>';
                            scheduleListHTML += '</div>';
                            scheduleListHTML += '</div>';
                        });
                        scheduleListHTML += '</div>';
                        $('#scheduleList').html(scheduleListHTML);
                    } else {
                        $('#scheduleList').html('<p class="text-center">Tidak ada jadwal tersedia.</p>');
                    }
                },
                error: function() {
                    $('#scheduleList').html('<p class="text-center">Terjadi kesalahan saat mengambil data jadwal.</p>');
                }
            });
        });

        // Fungsi untuk mengubah format tanggal ke "Jumat, 5 April 2024"
        function formatDate(dateString) {
            var options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            var date = new Date(dateString);
            return date.toLocaleDateString('id-ID', options);
        }

        // Fungsi untuk melihat detail jadwal
        function viewScheduleDetails(scheduleId) {
            window.location.href = 'schedule_details.php?id=' + scheduleId;
        }
    </script>

    <?php
    $user = $_SESSION['username'];
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        echo '<script>
				Swal.fire({
					title: "Selamat Datang ' . $user . ' ",
					text: "Anda Berhasil Login",
					icon: "success",
				});
			</script>';
        unset($_SESSION['login']);
    } ?>


</body>

</html>