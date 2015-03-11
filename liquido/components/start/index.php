<?php 

	include("lib/functions.php");
?>
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/liquido.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/mootools.js"></script>
<script type="text/javascript" scr="js/liquido.js"></script>
<!--[if IE]>
	<script type="text/javascript" src="pngfix.js"></script>
	<script>
		var supBrowser = (Browser.Engine.trident && !Browser.Engine.trident5 && document.body.filters) ? true : false;
		if (supBrowser) {
			window.addEvent('domready', function(){
				new pngFix({cssBgElements: ['#top']});
			});
		}
	</script>
<![endif]-->
<script type="text/javascript">
	<!--
	 if(this == top) document.location.href='/liquido/index.php';
	 top.head.location.href = 'head.php?location=start';
	 
	
	//-->
</script>

</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background:#b6b6b6 url(gfx/start_bg.png) repeat-x;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="225" align="center"><br>
	
		<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFF;">
        <tr> 
          <td width="6" height="6" class="rol"><img src="gfx/re_ol.gif" width="6" height="6"></td>
          <td class="ro"><img src="gfx/spacer.gif" width="1" height="1"></td>
          <td width="6" height="6"><img src="gfx/re_or.gif" width="6" height="6"></td>
        </tr>
        <tr> 
          <td class="rl"><img src="gfx/spacer.gif" width="1" height="1"></td>
          <td width="400" align="center"><table width="350" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> <p align="center"> 
                    <?php listcomponents(); ?>
                  </p></p>
                  <table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="center"><a href="?setmod=logout"><img src="components/logout/gfx/logo.gif" width="77" height="74" border="0"><br>
                        logout</a> </td>
                    </tr>
                  </table>
                  <br>
                  <?php	if ($user['memo']) { ?>
				  <table width="250" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="26" colspan="2" class="headline">Memo:</td>
                    </tr>
                    <tr> 
                      <td width="13">&nbsp; </td>
                      <td width="237">
                        <?php echo nl2br($user['memo']);	?>
					  
					  
                      </td>
                    </tr>
                  </table>
				  <?php }
				  
				  ?>
                  <p></p><div class="smalltext">liquido 3.0.1</div></td>
              </tr>
            </table></td>
          <td class="rr"><img src="gfx/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td height="6"><img src="gfx/re_ul.gif" width="6" height="6"></td>
          <td height="6" class="ru"><img src="gfx/spacer.gif" width="1" height="1"></td>
          <td height="6"><img src="gfx/re_ur.gif" width="6" height="6"></td>
        </tr>
      </table>
	  <div style="height:50px;width:413px; margin-top:10px; background:transparent url(gfx/start_mirror.png) no-repeat;"></div>
	  
	  
      <br>
    </td>
  </tr>
</table>
</body>
</html>
