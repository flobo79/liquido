<?php

include_once("liquido/lib/init.php");

/***** COUNTS THE CLICKED LINKS *******/
if(isset($_GET['url']) && isset($_GET['nlid'])) {
	$tbl = db_table("nl_linktracking");
	
	$sql = "insert into $tbl set 
		lt_link = '".mysql_real_escape_string($_GET['url'])."',
		lt_time = ".time().",
		pb_id = '".intval($_GET['nlid'])."'";
		
	$db->execute($sql);
	header("location:".$_GET['url']);

	
/******  UPDATES AREAS *****/
} elseif (is_array($set = $_POST['set'])) {
		
		$data = explode('/',$_POST['update']['mail']);                                                                                
		
        // erstelle separierten String zur Speicherung in DB                                                                          
        $mp = ";".implode(";", $set).";";                                                                                                                    
                                                                                                                                      
        // wenn von aktuellem updateform kommt, ist eine ID enthalten, welche dazu dient, einen Eintrag zu identifizieren             
        if(intval($data[1])) $and = " and id = '".intval($data[1])."' ";                                                              
        
        // puefe email Syntax                                                                                                         
        if(!preg_match("/^[A-Za-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$/", $data[0])) die("Die angegebene Email-Adresse kann nicht verwendet werden");
                                                                                                                                      
        // wenn alles ok ist erzeuge dbstring und los gehts                                                                           
        $sql = "update `$cfgtablenlabos` set `mp` = '$mp' where `email` = '".mysql_escape_string($data[0])."' $and LIMIT 1";          
        
        $db->execute($sql);                                                                                                            
                                                                                                                                  
        echo "Einstellungen gespeichert";                                                                                             
	
        /*
		} else {                                                                                                                              
        echo "Einstellungen konnten nicht gespeichert werden                                                                          
                                                                                                                                      
        Eventuell lassen Ihre Sicherheitseinstellungen nicht zu, Daten aus Ihrem E-Mail-Programm heraus zu versenden.                 
                                                                                                                                      
        Bitte verwenden Sie diesen Link um Ihre Bereichsauswahl zu speichern:                                                         
        <a href=\"http://www.vw-club.de/index.php?page=928\"> Bereichsauswahl aktualisieren </a>                                      
                                                                                                                                      
        Ihr Volkswagen Club                                                                                                           
        ";                                                                                                                            
*/


/******   REMOVE AN ABO    *****/
} elseif (isset($_GET['remove']) && intval($_GET['remove'])) {
	$db->execute("remove from ".db_table." where id = ".$_GET['remove']." LIMIT 1");
	$urladd = $db->addectedRows ? "true" : "false";
	
	if($_GET['return']) {
		header('location:'.$_GET['return']."?result=".$urladd);
	} else {
		//header('location:/newsletter-abgemeldet/?result=$urladd');
		echo "Newsletterabmeldung ".($urladd == 'true' ? 'erfolgreich' : '- Abo nicht gefunden');
		
	}


/*** WRITES THE READ STATISTIC *******/
} elseif (isset($_GET['ref']) && isset($_GET['nlid'])) {
	setReadStat($_GET['nlid'], $_GET['ref']);
	
	// schicke transparentes gif
	header('Content-type: image/gif');
	header('Expires: Sun, 2 Jul 1979 21:01:00 GMT');
	header('Cache-Control: no-cache');
	header('Cache-Control: must-revalidate');
	
	printf("%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%", 
		71,73,70,56,57,97,1,0,1,0,128,255,0,192,192,192,0,0,0,33,249,4,1,0,0,0,0,44,0,0,0,0,1,0,1,0,0,2,2,68,1,0,59);
	
		
		
		
		
		
		
		
	
/******** DISPLAYS THE LETTER *******/
} elseif ($_GET['load'] && intval($_GET['ref'])) {
	$pbid = $_GET['load'];
	$aboid = $_GET['ref'] / 1234;
	$abo = $db->getRow("select * from ".db_table('nl_abos')." where id=$aboid LIMIT 1");

	if($abo[0]) {
		setReadStat($pbid, $_GET['ref']);
		header('location:liquido/components/newsletter/publish/display.php?pbid='.$pbid."&aboid=$aboid");	
	} else {
		header('location:/');
	}
}





function setReadStat($pbid, $aboid) {
	$t_abos = db_table("nl_abos");
	$t_issues = db_table("nl_publishs");
	
	global $db;
	$aboid = ($aboid / 1234);
	$abo = $db->getRow("select * from ".$t_abos." where id = ".intval($aboid)." limit 1");
	
	if($abo['id']) {
		$reads = explode(";",$abo['issues_read']);
		$sents = explode(";",$abo['issues_sent']);

		if(in_array($pbid, $sents) && !in_array($pbid, $reads)) {
			$reads[] = $pbid;
			
			$db->execute("update $t_abos set issues_read = '".implode(";",$reads)."' where id = ".$aboid." LIMIT 1");
			$db->execute("update $t_issues set pb_reads = pb_reads+1 where pb_id = ".intval($pbid)." LIMIT 1");
		}
	}
	
	$db->execute("update $t_issues set pb_reads_total = pb_reads_total+1 where pb_id = ".intval($pbid)." LIMIT 1");
}


?>