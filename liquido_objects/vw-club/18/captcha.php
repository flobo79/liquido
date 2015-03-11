<?php

	// start session
	session_start();
	
	// generate hash value
	$hash = md5(uniqid(rand()));
	
	// cut value down to five characters
	$string = substr($hash,0,5);	
	
	// create image from .png
	$image = imagecreatefrompng("captcha.png");
	
	// allocate colors
	$white = imagecolorallocate($image,233,245,255);
	$black = imagecolorallocate($image,0,0,0);
	
	// draw some random lines
	for ($i=0; $i<10; $i++)
		imageline($image,0+rand(0,90),0,0+rand(0,90),30,$white);
	
	// font size
	$size = 12;
	$charwidth = 16;
	
	// write text
	for ($i=0; $i < strlen($string); $i++)
	{
		$char = substr($string,$i,1);
		imagettftext($image,$size,0+rand(0,45),16+($i*$charwidth),20,$black,'./1.ttf',$char);
	}
	
	// encrypt and store key in session
	$_SESSION['key'] = $string;

	// write header
	header("Content-type: image/jpeg");
	
	// output image
	imagejpeg($image);
	
	// release memory for picture
	imagedestroy($image);
	
?>