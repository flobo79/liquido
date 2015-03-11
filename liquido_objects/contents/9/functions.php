<?php
switch ($fncpart) {
	case "load":
		$source = $_FILES["uploadfile".$object[$i]];
		
		if($source and $source != "none") {
			// check ambient
			$dir = realpath("$cfgcmspath/objects/contents/9/documents");
			$docdir = $object[$i];
		
			$d = dir($dir."/".$docdir);
			while($entry=$d->read()) { 
				if($entry !="." and $entry != "..") {
					unlink($dir."/".$docdir."/".$entry);
				}
			}
			
			$thefile = "uploadfile$object[$i]"._name;
			copy($_FILES[$source],$dir."/".$docdir."/".$$thefile);	
		}
		break;
		
	case "delobject":

		mysql_query("delete from $objecttable where id = '$id'");
		exec("rm -r -f $cfgcmspath/objects/contents/8/documents/$id/");
		break;
}

?>