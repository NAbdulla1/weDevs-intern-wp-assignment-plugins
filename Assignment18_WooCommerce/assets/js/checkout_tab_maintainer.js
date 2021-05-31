; (function () {
	let currentTab = 0;//there will be two tabs, numbered 0 and 1
	showTab(currentTab);
	let nextBtn = document.getElementById('nextBtn');
	let prevBtn = document.getElementById('prevBtn');

	if (nextBtn)
		nextBtn.addEventListener('click', function (ev) {
			hideTab(currentTab);
			currentTab++;
			showTab(currentTab);
		});

	if (prevBtn)
		prevBtn.addEventListener('click', function (ev) {
			hideTab(currentTab);
			currentTab--;
			showTab(currentTab);
		});

	function showTab(n) {
		let tabs = document.getElementsByClassName("checkout-tab");
		if (tabs && tabs[n])
			tabs[n].style.display = "block";
	}

	function hideTab(n) {
		let tabs = document.getElementsByClassName("checkout-tab");
		if (tabs && tabs[n])
			tabs[n].style.display = "none";
	}
})();