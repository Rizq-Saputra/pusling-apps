<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pusling Aplication">
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
        <div class="mb-3">
            <label for="statusFilter" class="form-label">Status Kunjungan:</label>
            <select class="form-select" id="statusFilter">
                <option value="all">Semua</option>
                <option value="belum">Belum Dikunjungi</option>
                <option value="sudah">Sudah Dikunjungi</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="searchInput" class="form-label">Cari Kunjungan:</label>
            <input type="text" class="form-control" id="searchInput" placeholder="Masukkan kata kunci">
        </div>

        <div id="scheduleList"></div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            loadScheduleData();

            $('#statusFilter, #searchInput').on('change keyup', function() {
                loadScheduleData();
            });
        });

        function loadScheduleData() {
            var filter = $('#statusFilter').val();
            var searchKeyword = $('#searchInput').val();

            $.ajax({
                url: 'get_schedule.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    filter: filter, // Kirim nilai filter ke skrip PHP
                    search: searchKeyword // Kirim kata kunci pencarian ke skrip PHP
                },
                success: function(response) {
                    if (response && response.length > 0) {
                        var scheduleListHTML = '<div class="row">';
                        $.each(response, function(index, schedule) {
                            var formattedDate = formatDate(schedule.tanggal);

                            scheduleListHTML += '<div class="col-md-6 mb-4">';
                            scheduleListHTML += '<div class="card">';
                            scheduleListHTML += '<div class="card-body">';
                            scheduleListHTML += '<h5 class="card-title">' + schedule.tempat_kunjungan + '</h5>';
                            scheduleListHTML += '<p class="card-text"><strong>Tanggal :</strong> ' + formattedDate + '</p>';
                            scheduleListHTML += '<p class="card-text"><strong>Kecamatan :</strong> ' + schedule.kecamatan + '</p>';
                            scheduleListHTML += '<p class="card-text"><strong>Kontak :</strong> ' + schedule.kontak + '</p>';
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
        }

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