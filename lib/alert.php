<?php
if (isset($_SESSION['success'])) {
    $pesan = $_SESSION['success'];
    echo '<script>
					Swal.fire({
						title: "Sukses!",
						text: "' . $pesan . '",
						icon: "success",                
					});
				</script>';
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    $pesan = $_SESSION['error'];
    echo '<script>
				Swal.fire({
					title: "Gagal!",
					text: "' . $pesan . '",
					icon: "error",				
				});
			</script>';
    unset($_SESSION['error']);
}
