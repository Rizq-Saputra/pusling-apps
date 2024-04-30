const keyword = document.getElementById('keyword');
const sortSelect = document.querySelector('select[name="sort"]');
const statusSelect = document.querySelector('select[name="status"]');
const container = document.getElementById('container_table');
// Event listener untuk keyboard input pada input keyword
keyword.addEventListener('keyup', function() {
    const keywordValue = keyword.value;
    const sortValue = sortSelect.value;
    const statusValue = statusSelect.value;

    const url = `ajax/cari_kunjungan.php?keyword=${keywordValue}&sort=${sortValue}&status=${statusValue}`;
    
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText;
        }
    };

    xhr.open('GET', url, true);
    xhr.send();
});

// Event listener untuk perubahan pada elemen <select> sort
sortSelect.addEventListener('change', function() {
    const sortValue = sortSelect.value;
    const keywordValue = keyword.value;
    const statusValue = statusSelect.value;

    const url = `ajax/cari_kunjungan.php?keyword=${keywordValue}&sort=${sortValue}&status=${statusValue}`;
    
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText;
        }
    };

    xhr.open('GET', url, true);
    xhr.send();
});

// Event listener untuk perubahan pada elemen <select> status
statusSelect.addEventListener('change', function() {
    const statusValue = statusSelect.value;
    const keywordValue = keyword.value;
    const sortValue = sortSelect.value;

    const url = `ajax/cari_kunjungan.php?keyword=${keywordValue}&sort=${sortValue}&status=${statusValue}`;
    
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText;
        }
    };

    xhr.open('GET', url, true);
    xhr.send();
});
