
	{literal}
	<script language="JavaScript" type="text/JavaScript">
	<!--
		function save() {
			document.getElementById('save').style.display='none';
			document.getElementById('saveas').style.display='block';
			document.getElementById('input').focus();
		}
	//-->
	</script>
	{/literal}
	<input type="checkbox" name="checkbox" value="checkbox" onclick="parent.middle.location.href='body.php?loadtemplate=x'" {if $thiscomp.loadtemplate} checked {/if} />
	Vorlage laden<br/>
	<br/>
	<img src="gfx/content_pane_title2.gif" /><br/>
	<br/>
	{foreach from=$areas item=area}
	<input type="checkbox" name="{$area.area.id}" value="1" {if $area.area.checked } checked {/if} onclick="parent.middle.location.href='body.php?setcheck={$area.area.id}'">{$area.area.title|truncate:18:true:".."}<br/>
	{/foreach}

	<br/>
	<br/>
	<form name="testmail" method="post" action="?">Testmail an:<br>
		<input name="previewto" type="text" value="{$user.mail}" size="20"><br/>
		<input type="submit" value="absenden" /> <br/><br/>
		{if $sendresult}{$sendresult}{/if}
	</form>
