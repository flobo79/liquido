<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>liquido</title>
<link href="../styles.css" rel="stylesheet" type="text/css">
<link href="{$LIQUIDO}/css/liquido.css" rel="stylesheet" type="text/css">
<link href="{$SKIN}/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$LIQUIDO}/js/mootools.js"></script>
<script type="text/javascript" src="{$LIQUIDO}/js/utils.js"></script>
<script type="text/javascript" src="{$LIQUIDO}/js/liquido.js"></script>
</head>

<body>

<div class="content_centered" style="margin:5px; width:98%; ">
	<div id="list" style="display:block">
		<table id="details_list_issues" style="width:100%; ">
			<tr>
				<th>Betreff</th>
				<th>Status</th>
				<th>erstellt</th>
				<th>letzte Versendung</th>
				<th> </th>
				<th> </th>
			</tr>
			{foreach from=$issues item=issue}
			<tr class="{cycle values="row1,row2"}" onclick="parent.details.location.href='details.php?select[id]={$issue.id}'">
				<td style="cursor:pointer;">{$issue.title}</td>
				<td>{$stati[$issue.status]}</td>
				<td>{$issue.date|date_format:"%d. %m. %Y"}</td>
				<td>{if $issue.status >= 3}<img src="{$SKIN}/gfx/littlebar_red.gif" width="{$issue.laststat.length_bounce}" height="10" title="Rückläufer: {$issue.laststat.bounces.number}" /><img src="{$SKIN}/gfx/littlebar_green.gif" width="{$issue.laststat.length_reads}" height="10" title="gelesen: {$issue.laststat.pb_reads}" /><img src="{$SKIN}/gfx/littlebar_white.gif" width="{$issue.laststat.length_rest}" height="10" title="Gesamt: {$issue.laststat.pb_sent_total}"/>
					{$issue.laststat.pb_date|date_format:"%e. %m. %Y"} 
				{else} {/if}
				
				</td>
				<td></td>
				<td></td>
			</tr>
			{/foreach}
		</table>
		<a href="#" onclick="part('new'); part('list');">+ neue Kampagne erstellen</a>
	</div>
	<div id="new" class="hidden">
	{if $access.c2}
	  <form action="{$PHP_SELF}" method="post" name="newgroup">
	  <h1>Neue Kampagne erstellen</h1>
	  Geben Sie der Kampagne einen Titel, dieser wird bei der versendeten e-Mail als Betreffzeile angezeigt.<br>
        <table width="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="140" height="37">Betreff der Email:</td>
            <td><input name="insert[title]" type="text" id="new_group_input" value="neue Kampagne" size="48" /></td>
          </tr>
          <tr>
            <td valign="top">Info (intern):</td>
            <td><textarea name="insert[info]" cols="50" rows="3" class="text"></textarea></td>
          </tr>
          <tr>
            <td height="35"></td>
            <td>
 			<input type="submit" name="savenew" value="speichern" />
			<input type="button" name="cancel" value="abbrechen" onclick="part('new'); part('list'); reset();" />
		</td>
          </tr>
          <tr>
            <td colspan="2" valign="top"><a href="javascript:editors.submit()" onMouseOver="MM_swapImage('savegroupx','','{$LIQUIDO}/gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"> <br>
        </a></td>
          </tr>
        </table>
      </form>
	   {else}
	  Sie besitzen keine Berechtigung neue Kampagnen zu erstellen.
	  {/if}
	</div>
	 
</div>

</body>
</html>
