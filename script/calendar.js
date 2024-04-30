const daysTag = document.querySelector(".days");
const currentDateElements = document.querySelectorAll(".current-date");
const prevNextIcon = document.querySelectorAll(".icons span");
let date = new Date();
let currYear = date.getFullYear();
let currMonth = date.getMonth();

const daysIndonesian = [
  "Minggu",
  "Senin",
  "Selasa",
  "Rabu",
  "Kamis",
  "Jumat",
  "Sabtu",
];
const monthsIndonesian = [
  "Januari",
  "Februari",
  "Maret",
  "April",
  "Mei",
  "Juni",
  "Juli",
  "Agustus",
  "September",
  "Oktober",
  "November",
  "Desember",
];

const renderCalendar = () => {
  const firstDayOfMonth = new Date(currYear, currMonth, 1).getDay();
  const lastDateOfMonth = new Date(currYear, currMonth + 1, 0).getDate();
  const lastDayOfMonth = new Date(
    currYear,
    currMonth,
    lastDateOfMonth
  ).getDay();
  const lastDateOfLastMonth = new Date(currYear, currMonth, 0).getDate();

  let liTag = "";

  for (let i = firstDayOfMonth; i > 0; i--) {
    liTag += `<li class="inactive">${lastDateOfLastMonth - i + 1}</li>`;
  }

  for (let i = 1; i <= lastDateOfMonth; i++) {
    const isToday =
      i === date.getDate() &&
      currMonth === new Date().getMonth() &&
      currYear === new Date().getFullYear()
        ? "active"
        : "";
    liTag += `<li class="calendar-day ${isToday}">${i}</li>`;
  }

  for (let i = lastDayOfMonth; i < 6; i++) {
    liTag += `<li class="inactive">${i - lastDayOfMonth + 1}</li>`;
  }

  daysTag.innerHTML = liTag;

  daysTag.addEventListener("click", function (event) {
    const clickedElement = event.target;
    if (clickedElement.classList.contains("calendar-day")) {
        const dayNumber = clickedElement.innerText;
        const clickedDate = new Date(currYear, currMonth, parseInt(dayNumber) + 1);
        const formattedDate = clickedDate.toISOString().split("T")[0];
        const url = `ajax/cari_jadwal.php?keyword=${formattedDate}`;        
        const container = document.getElementById("list_jadwal");


      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          container.innerHTML = xhr.responseText;
        }
      };

      xhr.open("GET", url, true);
      xhr.send();
    }
  });

  daysTag.addEventListener("click", function (event) {
    const clickedElement = event.target;
    if (clickedElement.classList.contains("calendar-day")) {
        const dayNumber = clickedElement.innerText;
        const clickedDate = new Date(currYear, currMonth, parseInt(dayNumber) + 1);
        const formattedDate = clickedDate.toISOString().split("T")[0];
        const url = `ajax/tabel_jadwal.php?keyword=${formattedDate}`; 
        const container = document.getElementById("tabel_jadwal");


      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          container.innerHTML = xhr.responseText;
        }
      };

      xhr.open("GET", url, true);
      xhr.send();
    }
  });

  currentDateElements.forEach((element) => {
    element.innerText = `${daysIndonesian[date.getDay()]}, ${date.getDate()} ${
      monthsIndonesian[currMonth]
    } ${currYear}`;
  });

  daysTag.innerHTML = liTag;

  const formattedDate = `${date.getFullYear()}-${(date.getMonth() + 1)
    .toString()
    .padStart(2, "0")}-${date.getDate().toString().padStart(2, "0")}`;
};

const updateCalendar = () => {
  if (currMonth < 0 || currMonth > 11) {
    date = new Date(currYear, currMonth, new Date().getDate());
    currYear = date.getFullYear();
    currMonth = date.getMonth();
  } else {
    date = new Date();
  }
  renderCalendar();
};

const handleDayClick = (e) => {
  if (e.target && e.target.matches("li")) {
    const selectedDate = parseInt(e.target.textContent);
    date.setDate(selectedDate);
    renderCalendar();
  }
};

const handlePrevNextClick = (icon) => {
  currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
  updateCalendar();
};

daysTag.addEventListener("click", handleDayClick);

prevNextIcon.forEach((icon) => {
  icon.addEventListener("click", () => handlePrevNextClick(icon));
});

renderCalendar();
