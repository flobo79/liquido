
	<input type="checkbox" name="checkbox" value="checkbox" onclick="parent.middle.location.href='body.php?loadtemplate=x'" {if $thiscomp.loadtemplate} checked {/if} />
	Vorlage laden<br/><br/>
	<img src="gfx/compose_pane_position.gif" /><br>
	<a href="?setinsertpos=bottom"><img src="gfx/{if $insertpos == "bottom"}ins_b_d.gif{else}ins_b_u.gif{/if}" title="unten" /></a>
	<a href="?setinsertpos=middle"><img src="gfx/{if $insertpos == "middle"}ins_m_d.gif{else}ins_m_u.gif{/if}" title="mitte"/></a>
	<a href="?setinsertpos=top"><img src="gfx/{if $insertpos == "top"}ins_t_d.gif{else}ins_t_u.gif{/if}" title="oben"/></a><br/> 
	<br/>
	<img src="gfx/compose_pane_objects.gif" /><br/>
	{$objects}
	
	{literal}
	<style type="text/css">
		ul, li { padding:0; margin:0; list-style-type:none; cursor:pointer; }
		li { }
		#toolbar {
			position:fixed;
			right:0;
			top:10px;
		}
	</style>
	{/literal}
	<script type="text/javascript">
		// setup right hand column accordion
		var myAccordion = new Accordion($$('.acc_toggle'), $$('.acc_content'));
		
		
	</script>
	<a href="#" onclick="part('hints')"><strong>Platzhalter</strong></a>
  	<div id="hints" class="hidden">
		Sie können folgende Platzhalter verwenden:<br/>
		#anrede#<br/>
		#titel#<br/>
		#vorname#<br/>
		#nachname#<br/>
		#name#<br/>
		#email#<br/>
		#aboid#<br/>

	</div>	<br/>
	<br/>
	{if $access.c15}
	<img src="gfx/templates_title.gif"><br/> 
	list_templates($content);
	
<form name="form1" method="post" action="{$PHP_SELF}">
	<div id="save"><a href="javascript:savetemplate();">+ als Vorlage speichern</a></div>
	<div id="saveas" class="hidden"> 
	<input name="save_template" type="text" size="20" maxlength="20" class="text" style="width:130">
	</div>
	{/if}<br/>

	<p align="center"><a href="#" onclick="parent.middle.savex(); return false" onMouseOver="MM_swapImage('save','','gfx/compose_save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/compose_save.gif" name="save" border="0"></a><br>
	<a href="body.php#composebottom" target="middle"><img src="gfx/tobottom.gif" /></a> 
	<br/>
	</p>
</form>
