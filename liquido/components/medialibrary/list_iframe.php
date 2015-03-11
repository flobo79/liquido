<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

	NS = (document.layers) ? 1 : 0;
	IE = (document.all) ? 1: 0;
		
	setwidth = function(setwidth) {
		document.getElementById('iframe').width=setwidth;
		if(NS || IE) slide();
	}
	
	var foo = 0;
	slide = function() {
	
		var size = IE ? parseInt(document.body.offsetWidth) : parseInt(window.innerWidth);
		var scrolled = IE ? parseInt(document.body.scrollLeft) : parseInt(self.pageXOffset);
		var total = IE ? parseInt(document.body.scrollWidth) : parseInt(document.body.scrollWidth);
		
		var dist = (total - (size + scrolled));
		
		if(dist > 1) {
			foo = foo + (dist / 3);
			window.scroll((foo+20),0);
			window.setTimeout(slide,20);
			return false;

		} else {
			foo = 0;
			return false;
		}
	}
	
	
</script>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<iframe  bgcolor="#FFFFFF" src="list.php" width="250" height="90%" id="iframe" border="0" frameborder="0" framespacing="0" name="iframe" scrolling="AUTO" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0"></iframe>
</body>
</html>
