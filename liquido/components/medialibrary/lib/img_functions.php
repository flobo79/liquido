<?php

#  reprint #############
function reprint($data) {
	include("../../lib/init.php");
	include("lib/config.php");

	$insert[name] 	= "Abzug";
	$insert[info] 	= "Abzug von ".$data[name];
	$insert[parent] = $data[id];
	$insert[mime] 	= $data[mime];
	$insert[copy]	= 1;

	// sqleintrag
	$id = writeObject($insert);
	
	// make a copy of the Object
	$shc = "cp -r ../../".$cfgcmslibdir.$data[id]." ../../".$cfgcmslibdir.$id;
	exec($shc);

	return $id;
}


#  list_variantions  ###############
function listVariations($id) {
	include("../../lib/init.php");
	include("lib/config.php");
	
	$sql = "select * from $cfgTableMediaLib where parent = '$id' and copy = '1'";
	$q = mysql_query($sql);
	while($variation = mysql_fetch_array($q)) {
		if(!$started) {
			$part = "start";
			include("list_variations.php");
			$started = 1;
		}
		$part = "box";
		include("list_variations.php");
			
	}
	if($started) {
		$part = "end";
		include("list_variations.php");
	}
}

?>