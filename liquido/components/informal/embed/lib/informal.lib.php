<?php

function informal_error($message = 'Unknown Error')
{
	print $message;
}

function informal_fetch_get($parameter, $fatal = true)
{
	if ($_GET[$parameter]) {
		return $_GET[$parameter];
	} else if($fatal) {
		informal_error('Internal error (necessary GET parameter "' . $parameter . '" not given)');
	}
}

function informal_fetch_post($parameter, $fatal = true)
{
	if ($_POST[$parameter]) {
		return $_POST[$parameter];
	} else if($fatal) {
		informal_error('Internal error (necessary POST parameter "' . $parameter . '" not given)');
	}
}

?>
