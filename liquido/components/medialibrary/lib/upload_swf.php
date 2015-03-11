<?php

//  lib für die Bildverarbeitung
	if(!$fields['name']) 	$fields['name'] = $upload["title".$i];
	if(!$fields['info'])	$fields['info'] = $upload["info".$i];
	if(!$fields['parent'])	$fields['parent'] = $upload['id'];
	if(!$fields['mime'])	$fields['mime'] = 'swf';
	
	if(!$docid) $docid = writeObject($fields);
	
	$upload['path'] = $_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$docid;
	
	if(!file_exists(realpath($upload['path']))) mkdir($upload['path'],0777);
	copy($file,$upload['path']."/".$docid.".swf");
	chmod($upload['path'],0755);
			
?>		
