function sanitizeInput(inputValue) {
    // Hilangkan karakter simbol yang tidak diinginkan
    let sanitizedValue = inputValue.replace(/[<>\\[\];:`\-+=]/g, '');
    return sanitizedValue;
}

document.addEventListener('DOMContentLoaded', function() {
    let forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            // Mengambil semua input text dan textarea di dalam formulir
            let inputs = form.querySelectorAll('input[type="text"],input[type="date"] textarea');

            inputs.forEach(function(input) {
                // Mengambil nilai input
                let value = input.value;
                // Membersihkan nilai input menggunakan fungsi sanitizeInput
                let sanitizedValue = sanitizeInput(value);
                // Memperbarui nilai input dengan nilai yang sudah dibersihkan
                input.value = sanitizedValue;
            });

            // Memeriksa apakah formulir valid
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            // Menambahkan kelas 'was-validated' untuk menampilkan feedback invalid
            form.classList.add('was-validated');
        }, false);
    });
});
