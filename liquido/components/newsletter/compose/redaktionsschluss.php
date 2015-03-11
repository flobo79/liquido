<div id="infobox" class="infobox" style="margin:20px; padding:20px;border:1px solid #CCC;">
	<strong>Redaktionsschluß</strong><br/>
	Diese Bearbeitung an dieser Kampagne wurde bereits geschlossen.<br>
	Wenn Sie &Auml;nderungen durchf&uuml;hren m&ouml;chten, heben Sie den Redaktionsschluss auf.
</div>
<?php
	$template = getTemplate($nlobj['template']);
	$parser = new Parser();
	
	if(is_array($template)) {
		$parser->html = $template[0];
		echo $parser->parse();
	}
	
	$parser->html = $letter;
	echo $parser->parse();
	
	if($template[1]) {
		$parser->html = $template[1];
		echo $parser->parse();
	} ?>