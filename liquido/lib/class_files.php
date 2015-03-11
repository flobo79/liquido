<?php

class FILES {
	function rn($oldfile,$newfile) {
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$newfile)) {
			return exec("rn ".$_SERVER['DOCUMENT_ROOT'].$oldfile." ".$_SERVER['DOCUMENT_ROOT'].$newfile);
		} else { 
			return false;
		}
	}

	function listDir($dir) {
		if(is_dir($dir = $_SERVER['DOCUMENT_ROOT'].$dir)) {
			$dirs = array();
			$files = array();
			
			$d = dir($dir);
			
			while($entry=$d->read()) {
				if($entry != "." && $entry != "..") {				
					if(is_dir($dir.$entry)) {
						$dirs[] = $entry;
					} else {
						$files[] = $entry;
					}
				}
			}
			
			$d->close();
			$return['files'] = $files;
			$return['dirs'] = $dirs;
			
			return $return;
		} else {
			echo "Ordner $dir existiert nicht";
		}
	}
	
	function dirsize($dir) { 
		// ermittelt groesse eines verzeichnisses
		$dh = opendir($dir); 
		$size = 0; 
		
		while (($file = readdir($dh)) !== false) 
			if ($file != "." and $file != "..") { 
			   $path = $dir."/".$file; 

			   if (is_dir($path)) 
				 $size += $this -> dirsize($path); 
			   elseif (is_file($path)) 
				   $size += filesize($path); 
			} 
		closedir($dh);
		return $size; 
	}
	
	function saveChanges($file,$data) {
		if($fp = @fopen($_SERVER['DOCUMENT_ROOT'].$file,"w")) {
			$result = fwrite ($fp, $data);
			fclose ($fp);
		} else {
			$result = "error";
		}
		
		return $result;
	}
	
	function trimfilename($title,$length) {
		return (strlen($title) < $length) ? $title : substr($title,0,($bar = floor(($length-3) / 2)))."...".substr($title,-$bar);
	}
	
	function getfileperms($file,$full=0) {
		if($full) {
			$perms = fileperms($file);
			if (($perms & 0xC000) == 0xC000) {
			   // Socket
			   $info = 's';
			} elseif (($perms & 0xA000) == 0xA000) {
			   // Symbolic Link
			   $info = 'l';
			} elseif (($perms & 0x8000) == 0x8000) {
			   // Regular
			   $info = '-';
			} elseif (($perms & 0x6000) == 0x6000) {
			   // Block special
			   $info = 'b';
			} elseif (($perms & 0x4000) == 0x4000) {
			   // Directory
			   $info = 'd';
			} elseif (($perms & 0x2000) == 0x2000) {
			   // Character special
			   $info = 'c';
			} elseif (($perms & 0x1000) == 0x1000) {
			   // FIFO pipe
			   $info = 'p';
			} else {
			   // Unknown
			   $info = 'u';
			}
			
			// Owner
			$info .= (($perms & 0x0100) ? 'r' : '-');
			$info .= (($perms & 0x0080) ? 'w' : '-');
			$info .= (($perms & 0x0040) ?
					   (($perms & 0x0800) ? 's' : 'x' ) :
					   (($perms & 0x0800) ? 'S' : '-'));
			
			// Group
			$info .= (($perms & 0x0020) ? 'r' : '-');
			$info .= (($perms & 0x0010) ? 'w' : '-');
			$info .= (($perms & 0x0008) ?
					   (($perms & 0x0400) ? 's' : 'x' ) :
					   (($perms & 0x0400) ? 'S' : '-'));
			
			// World
			$info .= (($perms & 0x0004) ? 'r' : '-');
			$info .= (($perms & 0x0002) ? 'w' : '-');
			$info .= (($perms & 0x0001) ?
					   (($perms & 0x0200) ? 't' : 'x' ) :
					   (($perms & 0x0200) ? 'T' : '-'));
			
			return $info;
		} else {
			return substr(sprintf('%o', fileperms($file)), -4);
		}
	}
}

$files = new FILES;

?>