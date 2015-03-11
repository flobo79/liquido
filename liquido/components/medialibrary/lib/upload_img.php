<?php

	include_once("../../lib/class_transform.php");
	
	chmod($file,0777);
	
	// source-datei
	$upload['source'] = $file;
			
	// Bildinfos referenzieren
	if(!$fields['name']) 	$fields['name'] = $upload["title".$i];
	if(!$fields['info'])	$fields['info'] = $upload["info".$i];
	if(!$fields['parent'])	$fields['parent'] = $upload['id'];
	if(!$fields['mime'])	$fields['mime'] = 'picture';

	// Object in die Datenbank aufnehmen
	if(!$docid) $docid = writeObject($fields);
	
	
	if(!file_exists($_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$docid)) mkdir($_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$docid, 0777);
	$upload['path'] = $_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$docid;	// targetpath für thumbnail  

	//$upload['original'] = 1;				// saves the originalfile
	copy($file, $upload['path']."/original.jpg");
	
	if(!isset($imageTransform)) $imageTransform = new imageTransform;
	$imageTransform->resize($upload['source'], 500, 500, $upload['path'].'/large.jpg');
	$imageTransform->resize($upload['path'].'/large.jpg', 200, 500, $upload['path'].'/small.jpg');
	$imageTransform->resize($upload['path'].'/small.jpg', 50, 37, $upload['path'].'/thumbnail.jpg');
	

	unset ($docid,$upload);
			
?>