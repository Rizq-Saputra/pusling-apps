function ActiveMenu() {
	const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

	allSideMenu.forEach(item => {
		const li = item.parentElement;

		item.addEventListener('click', function () {
			allSideMenu.forEach(i => {
				i.parentElement.classList.remove('active');
			});
			li.classList.add('active');
		});
	});
}

function Sidebar(sidebar) {
	const menuBar = document.querySelector('#content nav .bx.bx-menu');

	menuBar.addEventListener('click', function () {
		sidebar.classList.toggle('hide');
		if (sidebar.classList.contains('hide')) {
			localStorage.setItem('sidebar', 'hide');
		} else {
			localStorage.removeItem('sidebar');
		}
	});

	return sidebar;
}

function ChangeTheme(switchMode) {
	if (document.body.classList.contains('dark')) {
		switchMode.checked = true;
	}

	switchMode.addEventListener('change', function () {
		if (this.checked) {
			document.body.classList.add('dark');
			localStorage.setItem('switchMode', 'dark');
		} else {
			document.body.classList.remove('dark');
			localStorage.setItem('switchMode', 'light');
		}
	});
}

document.addEventListener("DOMContentLoaded", function () {
	const switchMode = document.getElementById('switch-mode');
	const sidebar = document.getElementById('sidebar');
	const themeMode = localStorage.getItem('switchMode');
	const sidebarMode = localStorage.getItem('sidebar');

	ActiveMenu();
	Sidebar(sidebar);
	ChangeTheme(switchMode);

	if (sidebarMode === "hide") {
		sidebar.classList.add('hide');	
	}
	
	if (themeMode === 'dark') {
		document.body.classList.add('dark');
		switchMode.checked = true;
	}

	
});

