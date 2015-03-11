<?php 

//include("../../../../lib/init.php");
//auth();

while(list($var,$val) = each($selectimg)) {
	$link .= "selectimg[$var]=$val&";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>viewmode=listing</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="29,150,*" frameborder="NO" border="0" framespacing="0">
   <frame src="list_columnshead.php?<?php echo $link ?>" name="head" scrolling="NO" noresize >
   <frame src="list_details.php" name="Details" scrolling="AUTO" noresize >
   <frame src="list_iframe.php" name="mainFrame" scrolling="YES">
</frameset>
<noframes><body>

</body></noframes>
</html>
