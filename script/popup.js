function popupBox() {
    const add = document.querySelector(".add-data");
    const editButtons = document.querySelectorAll(".edit");
    const popupBox = document.querySelector(".popup-box");
    const popupTitle = popupBox.querySelector("header p");
    const closeIcon = popupBox.querySelector("header i");
    const titleTag = popupBox.querySelector("input");
    const descTag = popupBox.querySelector("textarea");
    const addBtn = popupBox.querySelector("button");

    add.addEventListener("click", () => {
        popupTitle.innerText = "Tambah Data Kunjungan";
        addBtn.innerText = "Tambah Data";
        popupBox.classList.add("show");
        document.querySelector("body").style.overflow = "hidden";
    });

    editButtons.forEach((editButton) => {
        editButton.addEventListener("click", () => {
            popupTitle.innerText = "Edit Data Kunjungan";
            addBtn.innerText = "Ubah Data";
            popupBox.classList.add("show");
            document.querySelector("body").style.overflow = "hidden";
        });
    });

    closeIcon.addEventListener("click", () => {
        isUpdate = false;
        titleTag.value = descTag.value = "";
        popupBox.classList.remove("show");
        document.querySelector("body").style.overflow = "auto";
    });

    // 	window.addEventListener('resize', function () {
	// 	if (this.innerWidth > 576) {
	// 		searchButtonIcon.classList.replace('bx-x', 'bx-search');
	// 		searchForm.classList.remove('show');
	// 	}
	// });
}

popupBox();