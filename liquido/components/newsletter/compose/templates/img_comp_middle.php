<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>image compose</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta http-equiv="pragma" content="no-cache">
<link href="<?php echo LIQUIDO; ?>/lib/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<div style="width:100%; text-align:center;" >
	<form name="form1" method="post" action="<?php echo $PHP_SELF ?>">
      <br/>
	  <p>
          <img src="<?php echo $img ?>"> <br>
          <textarea name="image[info]" style="width:<?php echo $size[0] ?>"><?php echo $image['info'] ?></textarea>
      </p>
      <table width="250," border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70">Breite: </td>
          <td width="180">
		  <input name="width" type="text" size="4" maxlength="4" value="<?php echo $size[0] ?>" />
            px</td>
        </tr>
        <tr>
          <td>Link:</td>
          <td><input name="link" type="text" value="<?php echo $image['link'] ?>" size="25" maxlength="150"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="save" type="submit" id="save" value="&uuml;bernehmen">
            <input name="id" type="hidden" id="id" value="<?php echo $image['id'] ?>"></td>
        </tr>
      </table>
    </form>
</div>
</body>
</html>
