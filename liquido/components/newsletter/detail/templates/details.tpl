<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>liquido</title>
<link href="{$LIQUIDO}/css/liquido.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$LIQUIDO}/js/mootools.js"></script>
<script type="text/javascript" src="{$LIQUIDO}/js/utils.js"></script>
<script type="text/javascript" src="{$LIQUIDO}/js/liquido.js"></script>
{if $updatelist}<script language="javascript" > parent.list.window.location.href=parent.list.window.location.href; </script>{/if}
{if $updateleft}<script language="javascript" > parent.parent.left.window.location.href=parent.parent.left.window.location.href; </script>{/if}
</head>

<body style="padding:5px;">
<div >
{if $data.id}
	<div style="float:left; width:300px; margin:5px;">
		<h1>{$data.title}</h1>
		<span class="smalltext">
			ID: {$data.id}, erstellt: {$data.date} Uhr<br>
			<br/>
 	  </span>
	{if $data.info}
		<table width="301" border="0" cellspacing="0" cellpadding="0">
			<tr> 
				<td width="24" align="center" valign="top"><img src="{$LIQUIDO}/gfx/info2.gif" width="15" height="15"></td>
				<td width="277">{$data.info|nl2br}<br>
				<br></td>
			</tr>
		</table></p>
	{/if}
	{if $access.c4}
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="#" onclick="part('windowproperties','edittitle','optprop','{$LIQUIDO}/gfx/less.gif')"><img src="../gfx/more.gif" alt="Optionen einblenden" id='optprop' name="more_prop"></a></td>
          <td width="265"><a href="#" onclick="part('windowproperties','edittitle','optprop','{$LIQUIDO}/gfx/less.gif')">Eigenschaften</a></td>
        </tr>
      </table>
      <div id="windowproperties" class="hidden">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr> 
				<td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coinsupg.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt="" /></td>
				<td height="15" background="{$LIQUIDO}/gfx/x_box/sup.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt="" /></td>
				<td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coinsupd.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt="" /></td>
			</tr>
		<tr> 
			<td width="15" background="{$LIQUIDO}/gfx/x_box/g.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
			<td background="{$LIQUIDO}/gfx/x_box/fond.gif" align="left" width="100%">
		  <form name="properties" method="post" action="{$PHP_SELF}" >
              <table width="300" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td valign="top">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                  <tr> 
                    <td width="90" valign="top">Betreff:</td>
                  <td width="210" valign="top"><input name="edit[title]" type="text" style="width:200px;" value="{$data.title}" size="35" id='edittitle' maxlength="100" class="text"></td>
                </tr>
                <tr> 
                  <td valign="top"> Bemerkung: </td>
                  <td valign="top"><textarea name="edit[info]" style="width:200px;" rows="5" class="text">{$data.info}</textarea></td>
                </tr>
                <tr> 
                  <td valign="top">
					 </td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr valign="bottom">
                  <td>Vorlage:</td>
                  <td>  
                      {if $access.c4}
					  <select name="edit[template]" class="text">
						<option>kein Template ausgewählt</option>
					  	{foreach from=$templates item=template}
						<option value="{$template.id}" {if $template.id == $data.template}selected{/if}>{$template.title}</option>
						{/foreach}
					   </select>
						{else}
						{$templates[$data.template].title}
						{/if}
                  </td>
                </tr>
                <tr valign="bottom" style="display:none"> 
                  <td>Inhaltsbreite:</td>
                  <td><input name="edit[width]" type="text" value="{$data.width}" size="4" maxlength="3" class="text" />
                    Pixel <a href="#"><img src="{$LIQUIDO}/gfx/info.gif" alt="?" title="Alle Inhaltsobjekte dieser Gruppe beziehen sich auf diese Breite" name="savepropx" /></a></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top" class="smalltext"> <br> 
                    {if $access.c5}
                    <a href="#" onClick="javascript:document.forms['properties'].submit();" onMouseOver="MM_swapImage('saveprop','','{$LIQUIDO}/gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="{$LIQUIDO}/gfx/save.gif" name="savepropx1" border="0" id="saveprop"></a> 
                    {/if}
                  </td>
                </tr>
              </table>
            </form> </td>
      <td width="15" background="{$LIQUIDO}/gfx/x_box/d.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
    </tr>
    <tr> 
      <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coininfg.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
      <td height="15" background="{$LIQUIDO}/gfx/x_box/inf.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
      <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coininfd.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
    </tr>
  </table>
  <br/> <br/>
  </div>
	{/if}
	
	{if $access.c7}
      <table width="332" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="#" onclick="part('publishwindow','edittitle','optpublish','{$LIQUIDO}/gfx/less.gif')"><img src="../gfx/more.gif" alt="Optionen einblenden" name="more_pub" id='optpublish' /></a></td>
          <td width="300"><a href="#" onclick="part('publishwindow','edittitle','optpublish','{$LIQUIDO}/gfx/less.gif')">Kampagne versenden</a></td>
        </tr>
      </table>
      <div id="publishwindow" class="hidden"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coinsupg.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td height="15" background="{$LIQUIDO}/gfx/x_box/sup.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coinsupd.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
          </tr>
          <tr> 
            <td width="15" background="{$LIQUIDO}/gfx/x_box/g.gif"> <img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td background="{$LIQUIDO}/gfx/x_box/fond.gif" align="left" width="100%"> 
              {if $data.status >= "3"}
              <form action="../body.php?setmode=publish" method="post" name="publish">
                {if $data.status > "3"}<br>
                <strong>Achtung! Diese Ausgabe wurde bereits veröffentlicht.</strong><br>
                <br>
                {/if}
                W&auml;hlen Sie eine oder mehrere Empf&auml;ngergruppen aus:<br>
                      <br>
				{section name=group loop=$groups}
				<input type="checkbox" name="publish[group][]" value="{$groups[group].id}" />
				{$groups[group].title}<br/>
				{/section} <br>
				<br>
				Wenn keine Gruppe ausgew&auml;hlt ist, wird der Newsletter an alle vorhandenen Abonnenten verschickt.<br>
									  <br/>
				Versendung jetzt starten?<br>
				<br>
				<input type="image" src="../gfx/ok.gif" alt="best&auml;tigen" name="" border="0" id="ok1" class="hand">
				<input type="hidden" name="publish[id]" value="{$data.id}">
				<input type="hidden" name="setmode" value="publish">
				<input type="hidden" name="publish[send]" value="publish">
				<input type="hidden" name="loc" value="publish_forked">
              </form>
              {else}
			  	Der Versand dieser Kampagne ist noch nicht zum Versand freigegeben.
			  {/if}
            </td>
            <td width="15" background="{$LIQUIDO}/gfx/x_box/d.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coininfg.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td height="15" background="{$LIQUIDO}/gfx/x_box/inf.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coininfd.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
          </tr>
        </table>
		<br/>
      </div>
      {/if}
	  {if $access.c3}
      <table width="333" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="32"><a href="#" onclick="part('delete','edittitle','optdel','{$LIQUIDO}/gfx/less.gif')"><img src="../gfx/more.gif" alt="Optionen einblenden" id="optdel" name="more_del" /></a></td>
          <td width="301"><a href="#" onclick="part('delete','edittitle','optdel','{$LIQUIDO}/gfx/less.gif')">Kampagne l&ouml;schen</a></td>
        </tr>
      </table>
      <div id="delete" class="hidden">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coinsupg.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td height="15" background="{$LIQUIDO}/gfx/x_box/sup.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coinsupd.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
          </tr>
          <tr>
            <td width="15" background="{$LIQUIDO}/gfx/x_box/g.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=" "></td>
            <td background="{$LIQUIDO}/gfx/x_box/fond.gif" align="left" width="100%"><form action="{$PHP_SELF}" method="post" name="delform">
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="346" colspan="2"><p><br>
                  Diese Ausgabe in den Papierkorb bewegen? </p>
                        <p> <a href="#" onClick="javascript:delform.submit();" onMouseOver="MM_swapImage('ex_temp1','','../gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"> <img src="../gfx/ok.gif" name="ex_temp1" border="0" id="ex_temp1"></a>
                            <input name="trash[type]" type="hidden"  value="contents">
                            <input name="trash[id]" type="hidden"  value="{$data.id}">
                      </p></td>
                  </tr>
                </table>
            </form></td>
            <td width="15" background="{$LIQUIDO}/gfx/x_box/d.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
          </tr>
          <tr>
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coininfg.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td height="15" background="{$LIQUIDO}/gfx/x_box/inf.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
            <td width="15" height="15" background="{$LIQUIDO}/gfx/x_box/coininfd.gif"><img src="{$LIQUIDO}/gfx/x_box/space15_15.gif" alt=""></td>
          </tr>
        </table>
    <br/>
	<br/>   
	</div>
  {/if}
	<div >
		<p class="headline"><strong>Freigabestatus:</strong></p>
		<input type="checkbox" name="setstatus" value="1" {if !$access.c6}disabled{else} onclick="document.location.href='?setstatus=1'"{/if}{if $data.status >= 1} checked{/if} />
		Redaktionsschluss<br>
		<input type="checkbox" name="setstatus" value="2" {if !$access.c7}disabled{else} onclick="document.location.href='?setstatus=2'"{/if}{if $data.status >= 2} checked{/if} />
		Redaktion freigegeben<br>
		<input type="checkbox" name="setstatus" value="3" {if !$access.c8}disabled{else} onclick="document.location.href='?setstatus=3'"{/if}{if $data.status >= 3} checked{/if} />
		Versand freigegeben
	</div>
</div>


{if $data.status>=3}
<div style="float:left; width:400px; margin:5px;">
	<h1>Statistik</h1>
	{foreach from=$data.publishs item=publish}
	<fieldset>
		<legend>Versendung vom {$publish.pb_date|date_format:"%A, %e. %m. %Y"}</legend>
			<h2>Leseverhalten:</h2>
			<img src="{$SKIN}/gfx/littlebar_red.gif" width="{$publish.bounces.barlength_bounce}" height="15" title="Rückläufer: {$publish.bounces.number}" /><img src="{$SKIN}/gfx/littlebar_green.gif" width="{$publish.bounces.barlength_reads}" height="15" title="gelesen: {$publish.pb_reads}" /><img src="{$SKIN}/gfx/littlebar_white.gif" width="{$publish.bounces.barlength_rest}" height="15" title="Gesamt: {$publish.pb_sent_total}"/><br/>
			ID der Versendung: {$publish.pb_id}<br/>
			Anzahl versendet: {$publish.pb_sent_total}<br/>
			Anzahl geöffnet: {$publish.pb_reads_total}<br/>
			Abonnenten erreicht: {$publish.pb_reads}<br/>
			Anzahl nicht zustellbar: {$publish.bounces.number}<br/>
			<br/>
			<h2>Benutzte Links:</h2>
			<p>
			{foreach from=$publish.clickedlinks item=link}
				<img src="{$SKIN}/gfx/littlebar_green.gif" width="{$link.barlength}" height="10"><img src="{$SKIN}/gfx/littlebar_white.gif" width="{$linkbarlength-$link.barlength}" height="10"> - {$link.lt_clicks} - <a target="_blank" href="{$link.lt_link}">{$link.lt_link}</a><br/>
			{foreachelse}
				es wurden keine geklickten Links verzeichnet
			{/foreach}
	</fieldset><br/>
	{/foreach}
</div>
{/if}

{else}
	<p></p>Bitte wählen Sie oben aus der Liste eine Kampagne aus oder erstellen Sie eine neue Kampagne.	</p>
{/if}
</div>
</body>
</html>