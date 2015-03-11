<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>image compose</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<meta http-equiv="pragma" content="no-cache">
<link href="{$LIQUIDO}/lib/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<div style="width:100%; text-align:center;" >
	<form name="form1" method="post" action="{$PHP_SELF}" style="width:100%; text-align:center;">
      <br/>
	  <p>
          <img src="{$img}"> <br>
          <textarea name="info" style="width:{$size[0]}">{$image.info}</textarea>
      </p>
      <table width="250" border="0" style="margin:0 auto; ">
        <tr>
          <td width="70">Breite ändern: </td>
          <td width="180">
		  <input name="width" type="text" size="4" maxlength="4" value="" />
            px ({$size[0]}px)</td>
        </tr>
        <tr>
          <td>Link:</td>
          <td><input name="link" type="text" value="{$image.link}" size="25" maxlength="150" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="save" type="submit" id="save" value="&uuml;bernehmen" />
            <input name="id" type="hidden" id="id" value="{$image.id}" /></td>
        </tr>
      </table>
    </form>
</div>
</body>
</html>
