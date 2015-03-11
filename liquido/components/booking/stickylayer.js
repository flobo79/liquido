
function getObj(name)
{
  if (document.getElementById)
  {
  	this.obj = document.getElementById(name);
	this.style = document.getElementById(name).style;
  }
  else if (document.all)
  {
	this.obj = document.all[name];
	this.style = document.all[name].style;
  }
  else if (document.layers)
  {
	this.obj = getObjNN4(document,name);
	this.style = this.obj;
  }
}

function getObjNN4(obj,name)
{
	var x = obj.layers;
	var foundLayer;
	for (var i=0;i<x.length;i++)
	{
		if (x[i].id == name)
		 	foundLayer = x[i];
		else if (x[i].layers.length)
			var tmp = getObjNN4(x[i],name);
		if (tmp) foundLayer = tmp;
	}
	return foundLayer;
}

var menu;
var theTop = 0;
var old = theTop;

window.onload = function () {
	menu = new getObj('tableheader');
	movemenu();
}

function movemenu()
{
	if (window.innerHeight)
	{
		  pos = window.pageYOffset
	}
	else if (document.documentElement && document.documentElement.scrollTop)
	{
		pos = document.documentElement.scrollTop
	}
	else if (document.body)
	{
		  pos = document.body.scrollTop
	}
	if (pos < theTop) pos = theTop;
	else pos += 0;
	if (pos == old)
	{
		menu.style.top = pos;
	}
	old = pos;
	temp = setTimeout('movemenu()',300);
}
