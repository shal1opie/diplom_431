function toggle() {
	let div = document.getElementsByClassName('no_need');

	for (var i = 0; i < div.length; ++i) {
		var obj = div[i];
		if (this.checked) obj.style.display = 'none';
		else obj.style.display = 'table-row'
	}
}
    document.getElementById('chkTest').onchange = toggle;