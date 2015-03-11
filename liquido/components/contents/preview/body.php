<?php 
	
	$node = new Node($thiscomp['id']);
	$node->nocache = true;
	$data = $node->data();

?><?php echo '<?xml version="1.0" ?>'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>liquido</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css" />
<link href="<?php echo LIQUIDO ?>/css/objects.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<?php foreach($cfg['components']['contents']['css'] as $lnk) { ?>
<link href="<?php echo $lnk; ?>" rel="stylesheet" type="text/css" />
<?php } ?>
<script src="<?php echo LIQUIDO ?>/js/mootools.js" type="text/javascript"></script>
<script src="<?php echo LIQUIDO ?>/js/utils.js" type="text/javascript"></script>
<script src="<?php echo LIQUIDO ?>/js/liquido.js" type="text/javascript"></script>
<script src="<?php echo LIQUIDO ?>/modules/swiff/swiffer.js" type="text/javascript"></script>


<script language="JavaScript" type="text/JavaScript">
<!--

function show(elementname,focusfield){
	document.getElementById(elementname).style.display='block';
	if(focusfield) {
		document.getElementById(focusfield).focus();
	}
}

function hide(elementname){
	document.getElementById(elementname).style.display='none';
}

//-->
</script>

<script type="text/javascript">
<!--
	function MM_swapImgRestore() { //v3.0
	  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
	}
	
	function MM_findObj(n, d) { //v4.01
	  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	  if(!x && d.getElementById) x=d.getElementById(n); return x;
	}
	
	function MM_swapImage() { //v3.0
	  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
	}


	function nofunct() {}

//-->
</script>


</head>

<body>

<div id="pagecontent">
	<div id="topbox">
		<?php if($data['cache']['refresh'] == "6") { ?>
			<div id="topbox_publish" onclick="document.location.href='?refresh=<?php echo $data['id'] ?>';">
			  Änderungen <br />veröffentlichen
			</div>
		  <?php } ?>
		<?php echo $data['title']; ?><br />
		<span class="smalltext">ID: <?php echo $node->id ?> - <?php showstatus($data['status']) ?></span>
	</div>

    <div id="contents" style="width:<?php echo $node->width ?>px;">

	<?php 
		$parser = new Parser($node->listobjects(),$node);
		echo $parser->parse(); 
	?>
	</div>
  <br />
</div>
</body>
</html>