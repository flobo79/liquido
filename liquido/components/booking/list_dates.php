<?
require_once("header.inc.php");

// Tabellenname ohne prefix
define("TABLENAME","dates");

// Anfang der Datensaetze, default = 0
$_start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;

// Anzahl der Datensaetze, default = 30
$_perpage = isset($_REQUEST['perpage']) ? intval($_REQUEST['perpage']) : 30;

// Abfrage-Ergebnisse begrenzen?
$_limit = isset($_REQUEST['start']) ? "LIMIT ".$_start.",".$_perpage : "";

// Suchbegriff angegeben?
$_where_arr = array();
define("SEARCHMASK","(p.pl_name LIKE '%%' OR p.pl_street LIKE '%%' OR p.pl_city LIKE '%%' OR p.pl_zipcode LIKE '%%' OR t.tr_designation LIKE '%%' OR p.pl_city LIKE '%%' )");
$_where = isset($_REQUEST['searchterm']) ? str_replace("%%","%".$booking->sql->SqlEscapeArg($_REQUEST['searchterm'])."%",SEARCHMASK) : "";
if($_where) $_where_arr[]=$_where;

// aktuelle Sortierungsspalte, default = Datum
$_sortfield = isset($_REQUEST['sort']) ? intval($_REQUEST['sort']) : 0;
$sortfields = array(
    "dt_date", // 0 Datum
    "tr_designation", // 1 Training
    "pl_name", // 2 Trainingsplatz
    "st_capacity_act", // 3 Freie Plaetze
);
$booking->tpl->assign("sort",$_sortfield);

// aktuelle Sortierungsreihenfolge, default = absteigend
$_sorttype = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 1;
$sorttypes = array(
    "asc",
    "desc"
);
$booking->tpl->assign("typeimg",'<img src="gfx/sort_'.$sorttypes[$_sorttype].'.gif" width="8" height="9" border="0" />');

$_urlsorttype = $_sorttype == 0 ? 1 : 0;
$booking->tpl->assign("sorturladd",$_urlsorttype);

// weitere Filter
$_where = isset($_REQUEST['showfrom']) ? "DATE_FORMAT(dt_date,'%Y-%m') >= '".$booking->sql->SqlEscapeArg($_REQUEST['showfrom'])."'" : "DATE_FORMAT(dt_date,'%Y-%m') >= '".$booking->sql->SqlEscapeArg(date("Y-m",strtotime("-1 month")))."'";
if($_where) $_where_arr[]=$_where;
$_where = isset($_REQUEST['showtill']) ? "DATE_FORMAT(dt_date,'%Y-%m') <= '".$booking->sql->SqlEscapeArg($_REQUEST['showtill'])."'" : ""; //DATE_FORMAT(dt_date,'%Y-%m') <= '".$booking->sql->SqlEscapeArg(date("Y-m"))."'";
if($_where) $_where_arr[]=$_where;
$_where = count($_where_arr) > 0 ? "WHERE ".implode(" AND ",$_where_arr) : "";

// wird ein objekt bearbeitet?
define("ITEMIDNAME","date_id");
if($_POST[ITEMIDNAME]) define("EDIT",true); else define("EDIT",false);

if(!empty($_POST)) {
	if($_POST['Delete']) {
		$_action="delete";
	} else if(!eregi("multi",$_POST['action'])) {
	   // validate nach POST
	   SmartyValidate::connect($booking->tpl);
	   if(SmartyValidate::is_valid($_POST)) {
	       // alles ok
	       SmartyValidate::disconnect();
	       if(EDIT) $_action = "update"; else $_action = "submit";
	   } else {
	       // Daten invalid
	       $_action = "invalidformdata";
	   }
   } else if($_POST['action']=="multiupdate") {
	   // validate nach POST
	   SmartyValidate::connect($booking->tpl);
	   if(SmartyValidate::is_valid($_POST)) {
	       // alles ok
	       SmartyValidate::disconnect();
	       $_action = "multiupdate";
	   } else {
	       // Daten invalid
	       $_action = "multiinvalidformdata";
	   }
	}
} else {
	// session daten fuer validate setzen
	SmartyValidate::connect($booking->tpl, true);
}

function parseSQLFields($date) {
    // TODO siehe header.inc.php, da stehts ebenfalls...
    switch($date['dt_frei']) {
    	case '0':
    		$date['dt_frei']="n";
    		break;
    	case '1':
    		$date['dt_frei']="j";
    		break;
    	case '2':
    		$date['dt_frei']="b";
    		break;
    }
    //echo "<pre>"; print_r($date); echo "</pre>";
	return $date;
}

function getDateById($id) {
	global $booking;
    $sql="SELECT *,DATE_FORMAT(dt_date,'%Y') AS Date_Year,DATE_FORMAT(dt_date,'%m') AS Date_Month,DATE_FORMAT(dt_date,'%d') AS Date_Day,DATE_FORMAT(dt_time,'%H') AS Time_Hour,DATE_FORMAT(dt_time,'%i') AS Time_Minute FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME." = '".intval($id)."' LIMIT 0,1";
    $date = $booking->sql->DB->GetRow($sql);
    return parseSQLFields($date);
}

function getPlaces() {
    // Trainingsplatz
    global $booking;
    $sql="SELECT p.place_id, CONCAT(c.co_name,' - ',p.pl_name) AS placename FROM ".PREFIX."places p JOIN ".PREFIX."countries c ON p.country_id = c.country_id ORDER BY c.co_name ASC, p.pl_name ASC";
    return $booking->sql->DB->GetAssoc($sql);
}

function getTrainings() {
    // Trainingsart
    global $booking;
    $sql="SELECT v.training_id, v.tr_designation FROM ".PREFIX."trainings v ORDER BY v.tr_designation ASC";
    return $booking->sql->DB->GetAssoc($sql);
}

function getWhereIdAddition() {
	$result="";
	$i=0;
	foreach($_POST['dates'] as $key=>$value) {
		$i++;
		$result.=ITEMIDNAME."='".intval($key)."'";
		if($i < count($_POST['dates'])) $result.=" OR ";
	}
	return $result;
}

function prepareDateByPostId($id, $forsql = false) {
	global $booking;
	$result=array();
	if($forsql) {
	    if($_POST['dt_frei'][$id]=="j") {
	    	// ja = 1
	    	$dt_frei="1";
	    }
	    else if($_POST['dt_frei'][$id]=="b") {
	    	// beschraenkt = 2
	    	$dt_frei="2";
	    }
	    else {
	    	// nein = 0
	    	$dt_frei="0";
	    }
		$result=array(
	        "place_id"=>intval($_POST['place_id'][$id]),
	        "dt_date"=>$booking->sql->SqlEscapeArg($_POST['Date_Year'][$id])."-".$booking->sql->SqlEscapeArg($_POST['Date_Month'][$id])."-".$booking->sql->SqlEscapeArg($_POST['Date_Day'][$id]),
	        "dt_time"=>"00000000".$booking->sql->SqlEscapeArg($_POST['Time_Hour'][$id]).$booking->sql->SqlEscapeArg($_POST['Time_Minute'][$id])."00",
	        "training_id"=>intval($_POST['training_id'][$id]),
	        "dt_capacity_max"=>intval($_POST['dt_capacity_max'][$id]),
	        "eventname"=>intval($_POST['eventname'][$id]),
	        "dt_frei"=>$dt_frei,
	    );
	} else {
	    $result=array(
			"date_id"=>$id,
	        "place_id"=>$_POST['place_id'][$id],
	        "Date_Year"=>$_POST['Date_Year'][$id],
	        "Date_Month"=>$_POST['Date_Month'][$id],
	        "Date_Day"=>$_POST['Date_Day'][$id],
	        "Time_Hour"=>$_POST['Time_Hour'][$id],
	        "Time_Minute"=>$_POST['Time_Minute'][$id],
	        "training_id"=>$_POST['training_id'][$id],
	        "dt_capacity_max"=>$_POST['dt_capacity_max'][$id],
	        "dt_frei"=>$_POST['dt_frei'][$id],
	        "val_dt_capacity_max"=>"dt_capacity_max_".$id,
	        "val_dt_frei"=>"dt_frei_".$id,
		);
    }
    return $result;
}

$booking->tpl->assign("formname",TABLENAME);

switch($_action) {
	case 'export':
	        switch($_GET['type']) {
	           case 'pdf':
	             //header("Content-type: application/pdf");
               //header("Content-Disposition: attachment; filename=termindetails_".$_GET['id'].".csv");
               $sql="SELECT r.*,DATE_FORMAT(r.rs_date,'%d.%m.%Y') AS rs_date_format FROM ".PREFIX."reserv r WHERE r.date_id='".intval($_GET['id'])."'";
               $reservierungen=$booking->sql->DB->GetAll($sql);
               $sql="SELECT d.date_id,d.dt_frei,DATE_FORMAT(d.dt_date,'%d.%m.%Y') AS datum,DATE_FORMAT(d.dt_time,'%H:%i Uhr') AS uhrzeit,d.st_capacity_act,d.dt_capacity_max, d.dt_capacity_max-d.st_capacity_act AS bookedplaces,(d.dt_capacity_max-d.st_capacity_act)/d.dt_capacity_max*100 AS bookedpercent,p.*,t.tr_designation FROM ".PREFIX."dates d JOIN ".PREFIX."places p ON d.place_id = p.place_id JOIN ".PREFIX."trainings t ON d.training_id = t.training_id WHERE d.date_id='".intval($_GET['id'])."'";
               //$date=getDateById($_GET['id']);
               $date=$booking->sql->DB->GetRow($sql);
               require_once("pdf/pdf_dates.inc.php");
	             die();
	             break;
	           default:
              $booking->tpl->assign("error","Fehler beim Exportieren des Termins.");
              $booking->tpl->assign("include","error.tpl");
	             break;
          }
	        break;
	case 'delete':
	        $sql="DELETE FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME."='".intval($_POST[ITEMIDNAME])."'";
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim L&ouml;schen des Termins."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Termin gel&ouml;scht. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'update':
	        // bearbeiten
	        $sql=array();
	        $querydata=$booking->sql->preparePostData(TABLENAME);
	        foreach($querydata['fields'] as $value) {
				$sql[]=$value."=".$querydata['values'][$value];
			}
			$sql="UPDATE ".PREFIX.TABLENAME." SET ".implode(",",$sql)." WHERE ".ITEMIDNAME." = '".intval($_POST[ITEMIDNAME])."'";
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim &Auml;ndern des Termins."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Termin aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'submit':
	        // Beim Anlegen von Terminen sollen die jeweils zuletzt vorgenommenen Datums- und Uhrzeiteinstellungen gespeichert bleiben.
	        unset($_SESSION['lasttrainingdateadded']);
	        $_SESSION['lasttrainingdateadded']['Date_Day']=$_POST['Date_Day'];
	        $_SESSION['lasttrainingdateadded']['Date_Month']=$_POST['Date_Month'];
	        $_SESSION['lasttrainingdateadded']['Date_Year']=$_POST['Date_Year'];
	        $_SESSION['lasttrainingdateadded']['Time_Hour']=$_POST['Time_Hour'];
	        $_SESSION['lasttrainingdateadded']['Time_Minute']=$_POST['Time_Minute'];
          // hinzufuegen
	        $querydata=$booking->sql->preparePostData(TABLENAME);
		    $fields=implode(",",$querydata['fields']);
		    $values=implode(",",$querydata['values']);
            $sql="INSERT INTO ".PREFIX.TABLENAME." (".$fields.",st_capacity_act) VALUES (".$values.",".$querydata['values']['dt_capacity_max'].")";
	        $ok=$booking->sql->DB->Execute($sql);
	        debug($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Hinzuf&uuml;gen des Termins."); //  <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Termin hinzugef&uuml;gt. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'edit':
          // aktuelle Sortierungsspalte, default = Datum
          $_sortfield = isset($_REQUEST['sort']) ? intval($_REQUEST['sort']) : 1;
          $sortfields = array(
              "rs_confirm_send", // 0
              "rs_date", // 1
              "rs_book_nr", // 2
              "rs_lastname", // 3
              "tr_designation", // 4
              "rs_places", // 5
              "rs_calc_send", // 6
              "rs_calc_paid", // 7
          );
          $booking->tpl->assign("sort",$_sortfield);
          
          // aktuelle Sortierungsreihenfolge, default = absteigend
          $_sorttype = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 1;
          $sorttypes = array(
              "asc",
              "desc"
          );
          $booking->tpl->assign("typeimg",'<img src="gfx/sort_'.$sorttypes[$_sorttype].'.gif" width="8" height="9" border="0" />');
          
          $_urlsorttype = $_sorttype == 0 ? 1 : 0;
          $booking->tpl->assign("sorturladd",$_urlsorttype);

          //$sql="SELECT r.rs_id, DATE_FORMAT(r.rs_date,'%d.%m.%Y') AS rs_date_format, r.rs_firstname, r.rs_lastname, r.rs_email, r.rs_street, r.rs_city, r.rs_phone, r.rs_fax, r.rs_places,r.rs_coupon_nr, r.rs_calc_send, r.rs_calc_paid, r.rs_book_nr, r.rs_confirm_send, r.rs_coupon, r.rs_remark, r.rs_names, r.rs_company,r.rs_company,DATE_FORMAT(r.rs_calc_senddate,'%d.%m.%Y um %H:%i Uhr') AS rs_calc_senddate_format,DATE_FORMAT(r.rs_calc_date,'%d.%m.%Y um %H:%i Uhr') AS rs_calc_date_format,DATE_FORMAT(r.rs_participantinfos_date,'%d.%m.%Y um %H:%i Uhr') AS rs_participantinfos_date_format,DATE_FORMAT(r.rs_announceconfirm_senddate,'%d.%m.%Y um %H:%i Uhr') AS rs_announceconfirm_senddate_format,DATE_FORMAT(r.rs_announceconfirm_recvdate,'%d.%m.%Y um %H:%i Uhr') AS rs_announceconfirm_recvdate_format FROM ".PREFIX."reserv r WHERE r.date_id='".intval($_GET['id'])."' ORDER BY ".$sortfields[$_sortfield]." ".$sorttypes[$_sorttype]."";
          $sql="SELECT r.rs_id, DATE_FORMAT(r.rs_date,'%d.%m.%Y') AS rs_date_format, r.rs_firstname, r.rs_lastname, r.rs_email, r.rs_street, r.rs_city, r.rs_phone, r.rs_fax, r.rs_places,r.rs_coupon_nr, r.rs_calc_send, r.rs_calc_paid, r.rs_book_nr, r.rs_confirm_send,r.rs_participantinfos_send,r.rs_announceconfirm_send,r.rs_announceconfirm_recv,r.rs_company,r.rs_invoice_nbr,r.rs_has_invalid_coupons, r.rs_coupon, r.rs_remark, r.rs_names,DATE_FORMAT(r.rs_calc_senddate,'%d.%m.%Y um %H:%i Uhr') AS rs_calc_senddate_format,DATE_FORMAT(r.rs_calc_date,'%d.%m.%Y um %H:%i Uhr') AS rs_calc_date_format,DATE_FORMAT(r.rs_participantinfos_date,'%d.%m.%Y um %H:%i Uhr') AS rs_participantinfos_date_format,DATE_FORMAT(r.rs_announceconfirm_senddate,'%d.%m.%Y um %H:%i Uhr') AS rs_announceconfirm_senddate_format,DATE_FORMAT(r.rs_announceconfirm_recvdate,'%d.%m.%Y um %H:%i Uhr') AS rs_announceconfirm_recvdate_format FROM ".PREFIX."reserv r WHERE r.date_id='".intval($_GET['id'])."' ORDER BY ".$sortfields[$_sortfield]." ".$sorttypes[$_sorttype]."";
          $reserv=$booking->sql->DB->GetAll($sql);
          $booking->tpl->assign("reservierungen",$reserv);
          
          $date=getDateById($_GET['id']);
          $booking->tpl->assign($date);
	case 'invalidformdata':
			if(!empty($_POST)) $booking->tpl->assign($_POST);
	case 'add':
	        // Beim Anlegen von Terminen sollen die jeweils zuletzt vorgenommenen Datums- und Uhrzeiteinstellungen gespeichert bleiben.
          if($_action=="add" && is_array($_SESSION['lasttrainingdateadded'])) {
  	        $booking->tpl->assign($_SESSION['lasttrainingdateadded']);
          }
          $booking->tpl->assign("places",getPlaces());
	        $booking->tpl->assign("trainings",getTrainings());
	        $booking->tpl->assign("editmode","single");
            $booking->tpl->assign("include","booking_dates_form.tpl");
            // Validierung
            if($_action=="add" || $_action=="edit") {
            	SmartyValidate::register_validator('dt_capacity_max', 'dt_capacity_max', 'isInt', false, false, 'trim');
            	SmartyValidate::register_validator('dt_frei', 'dt_frei', 'notEmpty', false, false, 'trim');
            }
	        break;
	case 'view':
	        // Liste anzeigen
			$sql="SELECT d.date_id,d.dt_frei,DATE_FORMAT(d.dt_date,'%d.%m.%Y') AS datum,DATE_FORMAT(d.dt_time,'%H:%i Uhr') AS uhrzeit,d.st_capacity_act,d.eventname,d.eventdetails,d.dt_capacity_max, d.dt_capacity_max-d.st_capacity_act AS bookedplaces,(d.dt_capacity_max-d.st_capacity_act)/d.dt_capacity_max*100 AS bookedpercent,d.dt_fullreservation,p.*,t.tr_designation FROM ".PREFIX."dates d JOIN ".PREFIX."places p ON d.place_id = p.place_id JOIN ".PREFIX."trainings t ON d.training_id = t.training_id ".$_where." ORDER BY ".$sortfields[$_sortfield]." ".$sorttypes[$_sorttype]." ".$_limit;
/*
			if($sortfields[$_sortfield]=="dt_date") {
			 $sql=str_replace("ORDER BY dt_date","ORDER BY STR_TO_DATE(CONCAT(DATE_FORMAT(d.dt_date,'%Y-%m-%d'),' ',DATE_FORMAT(d.dt_time,'%H:%i:%s')),'%Y-%m-%d %H:%i:%s')",$sql);
			 die($sql);
			 //ORDER BY ".$sortfields[$_sortfield]." ".$sorttypes[$_sorttype]." 
      }
*/
			if($sortfields[$_sortfield]=="dt_date") {
			 $sql=str_replace("ORDER BY dt_date","ORDER BY dt_date ".$sorttypes[$_sorttype].", dt_time",$sql);
      }
			//debug($sql);
			$termine=$booking->sql->DB->GetAll($sql);
			//die(print_r($booking->sql->DB));
            $booking->tpl->assign("termine_maxlen",getMaxLengths($termine));
            $booking->tpl->assign("termine",$termine);
            $booking->tpl->assign("include","booking_dates.tpl");
        	break;
    case 'multiinvalidformdata':
			if(!empty($_POST)) {
				$postdates=array();
				foreach($_POST['dates'] as $key=>$value) {
					$postdates[]=prepareDateByPostId($key,false);
				}
				$booking->tpl->assign("dates",$postdates);
	        	//debug($postdates);
			}
    case 'multiedit':
    		// TODO auf eine einzelne query umbauen?
	        $booking->tpl->assign("places",getPlaces());
	        $booking->tpl->assign("trainings",getTrainings());
	        // IDs merken
	        //$booking->tpl->assign("dates",$_POST['dates']);
    		$termine=array();
    		foreach($_POST['dates'] as $key=>$value) {
    			$date=getDateById($key);
    			if($_action!="multiinvalidformdata") {
	    			$date['val_dt_capacity_max']="dt_capacity_max_".$date['date_id'];
	    			$date['val_dt_frei']="dt_frei_".$date['date_id'];
	    			$date['Date_Suffix']="[".$date['date_id']."]";
    			}
		        $termine[]=$date;
	            // Validierung
	            if($_action=="multiadd" || $_action=="multiedit") {
	            	SmartyValidate::register_validator('dt_capacity_max_'.$key, 'dt_capacity_max['.$key.']', 'isInt', false, false, 'trim');
	            	SmartyValidate::register_validator('dt_frei_'.$key, 'dt_frei['.$key.']', 'notEmpty', false, false, 'trim');
	            }
    		}
    		if($_action!="multiinvalidformdata") {
	        	$booking->tpl->assign("dates",$termine);
    		}
	        $booking->tpl->assign("editmode","multi");
    		// TODO echo "<pre>"; print_r($termine); echo "</pre>";
            $booking->tpl->assign("include","booking_dates_form.tpl");
    		break;
	case 'multidel':
			$sql="DELETE FROM ".PREFIX.TABLENAME." WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim L&ouml;schen der Termine."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Termine gel&ouml;scht. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multisetfullreservation': // als ausgebucht markieren
			$sql="UPDATE ".PREFIX.TABLENAME." SET dt_fullreservation=1 WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Termine."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Termine aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multisetnotfullreservation': // als NICHT ausgebucht markieren
			$sql="UPDATE ".PREFIX.TABLENAME." SET dt_fullreservation=0 WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Termine."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Termine aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multisetfree': // freistellen
			$sql="UPDATE ".PREFIX.TABLENAME." SET dt_frei='1' WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Termine."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Termine aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multiblock': // zurueckziehen
			$sql="UPDATE ".PREFIX.TABLENAME." SET dt_frei='0' WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Termine."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Termine aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_dates.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multiupdate':
			foreach($_POST['dates'] as $key=>$value) {
				$data=prepareDateByPostId($key,true);
				//debug($data);
			    $fields=array();
			    foreach($data as $k=>$v) $fields[]=$booking->sql->SqlEscapeArg($k);
			    $querydata=array();
			    $querydata['fields']=$fields;
			    $querydata['values']=$data;
			    $sql=array();
		        foreach($querydata['fields'] as $value) {
					$sql[]=$value."='".$querydata['values'][$value]."'";
				}
				$sql="UPDATE ".PREFIX.TABLENAME." SET ".implode(",",$sql)." WHERE ".ITEMIDNAME." = '".intval($key)."'";
				//echo "<pre>$sql</pre>";
				$ok=$booking->sql->DB->Execute($sql);
		        if (!$ok) {
	                $booking->tpl->assign("error","Fehler beim &Auml;ndern der Termine."); // <!-- $sql -->
	                $booking->tpl->assign("include","error.tpl");
				} else {
					recalcFreePlaces();
	            	$booking->tpl->assign("hinweis","Termine aktualisiert. Bitte warten...");
	            	$booking->tpl->assign("redir","list_dates.php");
	            	$booking->tpl->assign("include","hinweis.tpl");
				}
			}
    		break;
    default:
    		echo $_action;
    		echo "<pre>"; print_r($_POST); echo "</pre>";
    		
        	break;
}

$booking->output("main.tpl");
?>
