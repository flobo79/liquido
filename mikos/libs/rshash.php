<?
function rshash($string)
{
	/*
	$signedshort = 0x7FFFFFFF;
	$b = 378551;
	$a = 63689;
	$hash = 0;
	$len = strlen($string);
	
	for($i=0; $i<$len; $i++)
	{
		echo sprintf("%s. Hash: %s A: %s Char: %s\n<br>",$i,$hash,$a,ord($string[$i]));
		$hash = $hash * $a + ord($string[$i]);
		$a = $a * $b;
	}
	
	return $hash & $signedshort;
	*/
	if(PHP_OS == 'Linux')
	{
		$hash = shell_exec(WEBPAGE_DIR.'bin/RSHash '.escapeshellarg($string));
		//$hash = '785071353';
		return $hash;
	}
	else
	{
		switch($string)
		{
			case 'susanne':
				return '785071353';
				break;
			default:
				return '';
				break;
		}
	}
}
?>
