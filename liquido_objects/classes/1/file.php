<?php

$objecttitle = "Passwortmaske";

switch ($part) {
	case "compose":
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
?> 
    	<textarea name="objectdata[<? echo $result['id']; ?>][text]" cols="20" class="feld" style="width:100%"><?php echo $result['text']; ?></textarea>
		Passwort: <input name="objectdata[<? echo $result['id']; ?>][text2]" type="text" class="text" value="<?php echo $result['text2']; ?>" size="20">
<?php	

		break;
	default:
	
	$show = false;
	$this_session_pw = $_SESSION['pagepassword'][$result['id']];
	if($_POST['pagedata']['setpw'] == $result['text2']) {
		$_SESSION['pagepassword'][$result['id']] = $_POST['pagedata']['setpw'];
		$show = true;
		
	} elseif ($this_session_pw == $result['text2']) {
		$show = true;
	}
	?>

	<br/>
	
	<?php if(!$show) { ?>
	
	<?php echo nl2br($result['text']); ?>
	
      <form name="form1" method="post" action="">
        Passwort: 
        <input name="pagedata[setpw]" type="password" class="feld">
        <input type="submit" name="Submit" value="login" class="button">
      </form>
	  
	<br>
	<?php 
	$endfunction = "1";
	}
	break;
}

?>
