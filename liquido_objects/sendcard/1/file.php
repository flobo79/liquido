<?php


// contents-template
$objecttitle = "E-Card lesen";

if ($part == "compose") {
	include($cfgcmspath."/components/contents/compose/templates/object_head.php");
	echo "<input name=\"objectdata[".$result['id']."][smalltext]\" type=\"hidden\" value=\"dummy\">";
}
?>
<script language="JavaScript">
	function getVar(varname) {
		var query = top.location.search.substring(1);
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if (pair[0] == varname) {
				return pair[1];
			}
		}
	}
	var cardid = getVar('cardid');

	 document.write('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="440" height="520">');
	 document.write('  <param name="movie" value="/sendcard/readcard.swf?cardid='+cardid+'">');
	 document.write('  <param name="quality" value="high">');
	document.write('  <param name="bgcolor" value="#FFFFFF">');
	 document.write('  <embed src="/sendcard/readcard.swf?cardid='+cardid+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="440" height="520"></embed></object>');

</script>

