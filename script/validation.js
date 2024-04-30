function sanitizeInput(inputValue) {
    let sanitizedValue = inputValue.replace(/[<>\\[\];:`\-+=]/g, '');
    return sanitizedValue;
}

document.addEventListener('DOMContentLoaded', function() {
    let forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            let inputs = form.querySelectorAll('input[type="text"],input[type="date"] textarea');

            inputs.forEach(function(input) {
                let value = input.value;
                let sanitizedValue = sanitizeInput(value);
                input.value = sanitizedValue;
            });

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
});
