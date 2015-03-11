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
		parent.details.location.href='detail_group.php?group='+id;
		self.location.href='?group='+id;	
	}
	selectUser = function (id) {
		parent.details.location.href='detail_editor.php?id='+id;	
	}
	
	<?php if($updatetop==1) { echo "parent.details.location.href='detail_group.php?group=$group';"; } ?>
	<?php if($updatetop==2) { echo "parent.details.location.href='detail_editor.php?id=$id';"; } ?>
	
	//-->
</script>

</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="form" method="post" action="">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="36">&nbsp;</td>
      <td width="185" valign="top"> 
        <?php list_groups($group); 
			  	if($access['c1']) {
			  ?>
        <div id="newgroup"><a href="javascript:newGroup();">neue Gruppe erstellen</a></div>
        <div id="newgroupx" style="display:none"> 
          <input name="new_group" type="text" size="25" maxlength="20" id="input" class="text">
          <br>
          <input type="submit" name="Submit" value="anlegen">
        </div>
        <?php } ?>
      </td>
      <td width="5" height="75" class="rl"><img src="../../gfx/spacer.gif" width="5" height="150"></td>
      <td width="197" valign="top"> 
        <?php	if($group) list_users($editor,$group);
			  
			  	if($group and $access['c4']) {
			  ?>
        <div id="newuser"><a href="javascript:newUser();">neuen Benutzer erstellen</a></div>
        <div id="newuserx" style="display:none"> 
          <input name="new_user" type="text" size="25" maxlength="20" id="input2" class="text">
          <br>
          <input type="submit" name="Submit2" value="anlegen">
        </div>
        <?php } ?>
      </td>
      <td width="5" valign="top" class="rl">&nbsp;</td>
      <td width="150" valign="top"> 
        <?php if($group and $access['c10']) listAreas($group)  ?>
      </td>
    </tr>
  </table>
</form>
</body>
</html>