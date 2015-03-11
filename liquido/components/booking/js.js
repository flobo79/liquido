var label = "";
var searchstring = "";
var file;
var showfrom;
var showtill;
var doaction;
var add = "";
var myselection = "";

addarticle = function () {
	window.open('contents/shop/plugins/articles/details.php','details','width=630,height=560,scrollbars=yes,resizable=yes');
}

showadd = function () {
	document.getElementById('new').style.display = 'block';
}

closeNew = function () {
	my_new = document.getElementById('new');
	my_new.style.display = "none";
	my_new.value="";
}

// select part
sl = function (showfile) {
	document.getElementById('listframe').src=showfile;
}

// search
searchthis = function (string) {
	searchstring = string;
	document.getElementById('delsearch').style.display=(searchstring != "" ? 'block' : 'none');
	reloadlist();
}

showduration = function () {
	showfrom = document.getElementById("from").value;
	showtill = document.getElementById('to').value;
	reloadlist();
}

showselection = function (showselection) {
	myselection = showselection;
	reloadlist();
	//showselection = "";
}

doaction = function (doaction,obj) {
	if(doaction != '') {
		top.frames['content']['iframe'].multiSubmit(doaction);
		obj.options[obj.selectedIndex=0];
	}
}

reloadlist = function () {
	// konsistente parameter
	add = "";
	if(searchstring != "") add += 'searchterm='+escape(searchstring)+'&';
	if(showfrom) add += 'showfrom='+showfrom+'&';
	if(showtill) add += 'showtill='+showtill+'&';
	
	// flüchtige parameter
	if(myselection != "") add += 'selection='+myselection+'&';
	// file wird in tpl_header.php definiert	
	
	// auf gehts ;-)
	document.getElementById('listframe').src=file+'?'+add;
}

show = function(targets,action) {
	targets = targets.split(",");
	for(i in targets) document.getElementById(targets[i]).style.display = action;
}

delsearch = function (file) {
	document.getElementById('search').value = '';
	document.getElementById('delsearch').style.display='none';
	
	searchthis('');
}

function check(id) {
	for(i=1;obj = document.getElementById('o'+i);i++) {
		document.getElementById('o'+i).className=('o'+i==id) ? 'activeicon' : '';
	}
}

function printIframe(iframe) {
	iframe.focus();
	iframe.print();
}
