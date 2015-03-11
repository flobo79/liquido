
// search
searchstring = '';
setgroup = '';

selectgroup = function (setmygroup) {
	setgroup = setmygroup ? setmygroup : "";
	reloadlist();
}

searchthis = function () {
	searchstring = document.getElementById('searchbox_input').value;
	document.getElementById('searchbox_clear').style.display=(searchstring != "" ? 'block' : 'none');
	reloadlist();
}

reloadlist = function () {
	add = (searchstring != "") ? '&search='+escape(searchstring) : "";
	add += '&setgroup='+setgroup;
	parent.middle.document.location.href='body.php?setmode=abo&amp;page=search.php'+add;
}

delsearch = function () {
	searchstring = document.getElementById('searchbox_input').value='';
	searchthis();
}

