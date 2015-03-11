<?php

switch ($fncpart) {
	case "load":
		
		/*
		global $_FILES;
		$source = $_FILES['uploadfile']['name'][$result['id']];
		if($source and $source != "none") {
			// check ambient
			$dir = $_SERVER['DOCUMENT_ROOT'].DOCUMENTS."/".$result['id']."/";
		
			$d = dir($dir);
			while($entry=$d->read()) { 
				if($entry !="." and $entry != "..") {
					unlink($dir.$entry);
				}
			}
			$thefile = urlencode($_FILES['uploadfile']['name'][$result['id']]);
			$thesource = $_FILES['uploadfile']['tmp_name'][$result['id']];
			copy($thesource,$dir.$thefile);	
		}
		*/
		break;
		
	case delobject:
		if(strlen(DOWNLOADSDIR) > 2) {
			mysql_query("delete from $objecttable where id = '$id'");
			//exec("rm -r -f ".$_SERVER['DOCUMENT_ROOT'].DOCUMENTS."/".$id."/");
		}
		break;
}

?>