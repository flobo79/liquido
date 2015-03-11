<?php 

global $left_search;
switch ($part) {
	case "top":
	
?>
<link href="<?php echo CMSPATH ?>/tpl/blue/styles.css" rel="stylesheet" type="text/css">
<?php if($left_search) { ?>
	<div id="searchbox">
		<div id="searchbox_clear" onclick="document.getElementById('search').value='';<?php echo $left_search_fnc ?> ">&nbsp;</div>
		<div id="searchbox_inputbox"><input type="text" name="search" id="search" value="<?php echo $search ?>" onkeydown="<?php echo $left_search_fnc ?>" /></div>
	</div>
<?php }?>
	<div id="leftpane_content_box">
		<div id="leftpane_content">
<?php break;
	case "bottom":
?>
		</div>
	</div>
<?php break;
	}
?>