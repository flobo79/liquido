<?php

	include("lib/functions.php");

?>
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/markRows.js"></script>
<script type="text/javascript">
	<!--
	
	function newGroup(){
		document.getElementById('newgroup').style.display='none';
		document.getElementById('newgroupx').style.display='block';
		document.getElementById('input').focus();
	}
	
	function newUser(){
		document.getElementById('newuser').style.display='none';
		document.getElementById('newuserx').style.display='block';
		document.getElementById('input2').focus();
	}
	
	
	
	selectGroup = function (id) {
		self.location.href='?group='+id;	
	}
	selectUser = function (id) {
		self.location.href='?group=<?php echo $group ?>&editor='+id;	
	}
	//-->
</script>

</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="730" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="395" valign="top"><form name="form" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="25"><img src="../../gfx/spacer.gif" width="25" height="25"></td>
            <td width="180"><img src="../../gfx/spacer.gif" width="180" height="8"></td>
            <td><img src="../../gfx/spacer.gif" width="10" height="25"></td>
            <td><img src="../../gfx/spacer.gif" width="180" height="8"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="ru">Gruppen</td>
            <td class="ru">&nbsp;</td>
            <td class="ru">Benutzer</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td valign="top"> <br> 
              <?php list_groups($group); 
			  	if($access['c1']) {
			  ?>
              <div id="newgroup"><a href="javascript:newGroup();">neue Gruppe 
                erstellen</a></div>
              <div id="newgroupx" style="display:none"> 
                <input name="new_group" type="text" size="25" maxlength="20" id="input" class="text">
                <br>
                <input type="submit" name="Submit" value="anlegen">
              </div>
			  <?php } ?>
			  </td>
            <td height="75" class="rl"><img src="../../gfx/spacer.gif" width="8" height="150"></td>
            <td valign="top"> <br> 
              <?php	if($group) list_users($editor,$group);
			  
			  	if($group and $access['c4']) {
			  ?>
              <div id="newuser"><a href="javascript:newUser();">neuen Benutzer 
                erstellen</a></div>
              <div id="newuserx" style="display:none"> 
                <input name="new_user" type="text" size="25" maxlength="20" id="input2" class="text">
                <br>
                <input type="submit" name="Submit2" value="anlegen">
              </div>
			  <?php } ?>
			  </td>
          </tr>
        </table>
      </form></td>
    <td width="335" valign="top">
	<form action="" method="post" name="detailsform" id="detailsform">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="25"><img src="../../gfx/spacer.gif" width="25" height="25"></td>
            <td width="310"><p><img src="../../gfx/spacer.gif" width="310" height="8"></p></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="ru">Eigenschaften</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td valign="top"> <br> 
              <?php 
	if($editor) {
		include("detail_user.php");
	} elseif($group) {
		include("detail_group.php");
	} 
?>
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>