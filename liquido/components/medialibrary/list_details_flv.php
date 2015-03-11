<?php $file = MEDIALIB."/".$result['id']."/".$result['id'].".flv"; ?>
<div style="margin:10px;">
	<div style="float:left">
		<embed src="../../modules/flvplayer/player.swf?file=<?php echo $file ?>&size=false&aplay=false&autorew=false" menu="false" quality="high" bgcolor="#FFF" width="200" height="150" name="player" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</div>
	
	<div style="float:left;margin-left:15px;">
	    <span class="headline"> <?php echo $result['name'] ?></span><br>
	        Nummer: <?php echo $result['id'] ?>
	      <p> <?php echo $result['info'] ?> </p>
	      <p>&nbsp;</p>
	      <p>erstellt: <?php echo $result['date'] ?><br>
	        ge&auml;ndert: <?php echo $result['changed'] ?> </p>
	      <p> 
	        <?php if($access['c5']) { ?>
	        <input type="button" onclick="document.location.href='list_edit.php?id=<?php echo $id ?>'" value="bearbeiten" />
	        <?php } ?>
	        <?php if($access['c6']) { ?>
			<input type="button" onclick="document.location.href='list_delete.php?id=<?php echo $id ?>'" value="löschen" />
	        <?php } ?>
	        <br>
	     
	</div>
</div>