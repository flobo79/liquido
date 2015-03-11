<div class="content_centered">

    <td><p class="	">Abonnenten austragen</p>
      <form name="form1" method="post" action="">
        <?php if($removeresult['ok']) unset($remove); ?>
			<p>
                <input name="remove[mail]" type="text" id="search" value="<?php echo $remove['mail'] ?>"> 
                <?php echo $removeresult['mail'] ?>
                <input type="submit" value="austragen" />
                <?php echo $removeresult['ok'] ?>
                <input name="file" type="hidden" id="file" value="remove.php">
</p>
			<p>Tragen Sie hier die e-Mail Adresse ein die gel&ouml;scht werden soll. Achtung, alle Vorkommen und alle Verknüpfungen werden gelöscht. </p>
	  </form>
</div>