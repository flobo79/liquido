<?
require_once("header.inc.php");

// Tabellenname ohne prefix
define("TABLENAME","reserv");

// Anfang der Datensaetze, default = 0
$_start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;

// Anzahl der Datensaetze, default = 30
$_perpage = isset($_REQUEST['perpage']) ? intval($_REQUEST['perpage']) : 30;

// Abfrage-Ergebnisse begrenzen?
$_limit = isset($_REQUEST['start']) ? "LIMIT ".$_start.",".$_perpage : "";

// Suchbegriff angegeben?
$_where_arr = array();
define("SEARCHMASK","(r.rs_firstname LIKE '%%' OR r.rs_lastname LIKE '%%' OR r.rs_email LIKE '%%' OR r.rs_street LIKE '%%' OR r.rs_city LIKE '%%' OR r.rs_phone LIKE '%%' OR r.rs_fax LIKE '%%' OR r.rs_book_nr LIKE '%%' OR p.pl_name LIKE '%%' OR p.pl_street LIKE '%%' OR p.pl_zipcode LIKE '%%' OR p.pl_city LIKE '%%' OR t.tr_designation LIKE '%%')");
$_where = isset($_REQUEST['searchterm']) ? str_replace("%%","%".$booking->sql->SqlEscapeArg($_REQUEST['searchterm'])."%",SEARCHMASK) : "";
if($_where) $_where_arr[]=$_where;

// aktuelle Sortierungsspalte, default = Datum
$_sortfield = isset($_REQUEST['sort']) ? intval($_REQUEST['sort']) : 1;
$sortfields = array(
    "rs_confirm_send", // 0
    "rs_date", // 1
    "rs_book_nr", // 2
    "rs_lastname", // 3
    "dt_date", // 4
    "rs_places", // 5
    "rs_calc_send", // 6
    "rs_calc_paid", // 7
    "rs_participantinfos_send", // 8
    "rs_announceconfirm_send", // 9
    "rs_announceconfirm_recv", // 10
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
// ab datum
$_where = isset($_REQUEST['showfrom']) ? "DATE_FORMAT(rs_date,'%Y-%m') >= '".$booking->sql->SqlEscapeArg($_REQUEST['showfrom'])."'" : "DATE_FORMAT(rs_date,'%Y-%m') >= '".$booking->sql->SqlEscapeArg(date("Y-m",strtotime("-1 month")))."'";
if($_where) $_where_arr[]=$_where;
// bis datum
$_where = isset($_REQUEST['showtill']) ? "DATE_FORMAT(rs_date,'%Y-%m') <= '".$booking->sql->SqlEscapeArg($_REQUEST['showtill'])."'" : "DATE_FORMAT(rs_date,'%Y-%m') <= '".$booking->sql->SqlEscapeArg(date("Y-m"))."'";
if($_where) $_where_arr[]=$_where;
// "zeige..." dropdown filter
switch($_REQUEST['selection']) {
	case 'notconfirmed': // nicht bestaetigt
		$_where="rs_confirm_send = '0'";
		break;
	case 'notsent': // rechnung nicht versandt
		$_where="rs_calc_send = '0'";
		break;
	case 'notpayed': // rechnung nicht bezahlt
		$_where="rs_calc_paid = '0'";
		break;
	case 'notparticipantinfossend': // Teilnehmerunterlagen nicht verschickt
		$_where="rs_participantinfos_send = '0'";
		break;
	case 'notannounceconfirmsend': // Anmeldebestaetigung nicht versandt
		$_where="rs_announceconfirm_send = '0'";
		break;
	case 'notannounceconfirmrecv': // Anmeldebestaetigung nicht erhalten
		$_where="rs_announceconfirm_recv = '0'";
		break;
	case 'coupons': // gutschein verwendet
		$_where="rs_coupon_nr > '0'";
		break;
	default:
		$_where="";
		break;
}
if($_where) $_where_arr[]=$_where;
// sql query zusatz bauen
$_where = count($_where_arr) > 0 ? "WHERE ".implode(" AND ",$_where_arr) : "";

// wird ein objekt bearbeitet?
define("ITEMIDNAME","rs_id");
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

//function parseSQLFields($date) {
//    // TODO siehe header.inc.php, da stehts ebenfalls...
//    switch($date['dt_frei']) {
//    	case '0':
//    		$date['dt_frei']="n";
//    		break;
//    	case '1':
//    		$date['dt_frei']="j";
//    		break;
//    	case '2':
//    		$date['dt_frei']="b";
//    		break;
//    }
//    //echo "<pre>"; print_r($date); echo "</pre>";
//	return $date;
//}
//
function getBookingById($id) {
	global $booking;
    $sql="SELECT rs_id,date_id,rs_lastname,rs_firstname,rs_company,rs_places,rs_coupon,rs_coupon_nr,rs_street,rs_city,rs_email,rs_phone,rs_fax,rs_remark,rs_names FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME." = '".intval($id)."' LIMIT 0,1";
    return $booking->sql->DB->GetRow($sql);
}

function getUsedCouponsById($id) {
	global $booking;
    $sql="SELECT cp_nr FROM ".PREFIX."coupons WHERE cp_rs_id = '".intval($id)."'";
    return implode(", ",$booking->sql->DB->GetCol($sql));
}

function getDatesAsOptions($add="") {
    global $booking;
    $sql="SELECT d.date_id,CONCAT(DATE_FORMAT(d.dt_date,'%d.%m.%Y '),DATE_FORMAT(d.dt_time,'%H:%i: '),d.eventname,' - ',p.pl_name,' (',d.st_capacity_act,' frei)') AS training FROM ".PREFIX."dates d JOIN ".PREFIX."places p ON d.place_id=p.place_id JOIN ".PREFIX."trainings t ON d.training_id=t.training_id WHERE d.st_capacity_act > 0 $add ORDER BY d.dt_date DESC, d.dt_time ASC, p.pl_name ASC";
    //die($sql);
    return $booking->sql->DB->GetAssoc($sql);
}

function getWhereIdAddition() {
	$result="";
	$i=0;
	foreach($_POST['reserv'] as $key=>$value) {
		$i++;
		$result.=ITEMIDNAME."='".intval($key)."'";
		if($i < count($_POST['reserv'])) $result.=" OR ";
	}
	return $result;
}

function analyzeCoupons() {
  global $booking;
  //$log=array();
  $sql="SELECT rs_id,date_id,rs_coupon,rs_coupon_nr FROM ".PREFIX.TABLENAME." WHERE rs_coupon IS NOT NULL AND rs_coupon != ''";
  $coupondata=$booking->sql->DB->GetAll($sql);
  foreach($coupondata as $reserv) {
    $coupons=explode(",",str_replace(";",",",$reserv['rs_coupon']));
    foreach($coupons as $coupon) {
      $coupon = trim($coupon);
      // suche nach Coupons die noch nie verwendet wurden
      $sql="SELECT * FROM ".PREFIX."coupons WHERE cp_nr = '".$booking->sql->SqlEscapeArg($coupon)."' AND ((cp_usedate = 0 AND cp_rs_id = 0) OR (cp_rs_id = ".intval($reserv['rs_id']).")) LIMIT 0,1";
      $cpr=$booking->sql->DB->GetRow($sql);
      if($cpr['cp_id']) {
        // Coupon existiert...
        //$log[]="Coupon existiert schon mal: ".$coupon;
        if($cpr['cp_rs_id'] == $reserv['rs_id']) {
          // schon der korrekten Reservierung zugeordnet, ueberspringen
          $log[]="Coupon schon der korrekten Reservierung zugeordnet: ".$coupon;
          continue;
        }
        // Reservierung zuweisen
        $sql="UPDATE ".PREFIX."coupons SET cp_usedate = ".time().", cp_rs_id = ".intval($reserv['rs_id'])." WHERE cp_id = ".intval($cpr['cp_id']);
        //$log[]="Coupon der Reservierung zugeordnet: ".$coupon;
        $ok=$booking->sql->DB->Execute($sql);
        if(!$ok) {
          die("Error Updating Coupon Data: $sql");
        }
      } else {
        // fehlerhafter Coupon
        $sql="UPDATE ".PREFIX.TABLENAME." SET rs_has_invalid_coupons = 1 WHERE rs_id = ".intval($reserv['rs_id']);
        //$log[]="fehlerhafter Coupon: ".$coupon;
        $ok=$booking->sql->DB->Execute($sql);
        if(!$ok) {
          die("Error Updating Coupon Data: $sql");
        }
      }
    }
  }
  //echo "<!-- ".implode("\n",$log)." -->\n";
}

function prepareReservByPostId($id, $forsql = false) {
	global $booking;
	$result=array();
	if($forsql) {
	  $rs_coupon_nr = $_POST['rs_coupon'][$id] ? count(explode(",",str_replace(" ","",$_POST['rs_coupon'][$id]))) : 0;
		$result=array(
	        "date_id"=>intval($_POST['date_id'][$id]),
	        "rs_lastname"=>$booking->sql->SqlEscapeArg($_POST['rs_lastname'][$id]),
	        "rs_firstname"=>$booking->sql->SqlEscapeArg($_POST['rs_firstname'][$id]),
	        "rs_company"=>$booking->sql->SqlEscapeArg($_POST['rs_company'][$id]),
	        "rs_places"=>intval($_POST['rs_places'][$id]),
	        "rs_coupon"=>$booking->sql->SqlEscapeArg($_POST['rs_coupon'][$id]),
	        "rs_coupon_nr"=>$rs_coupon_nr,
	        "rs_street"=>$booking->sql->SqlEscapeArg($_POST['rs_street'][$id]),
	        "rs_city"=>$booking->sql->SqlEscapeArg($_POST['rs_city'][$id]),
	        "rs_email"=>$booking->sql->SqlEscapeArg($_POST['rs_email'][$id]),
	        "rs_phone"=>$booking->sql->SqlEscapeArg($_POST['rs_phone'][$id]),
	        "rs_fax"=>$booking->sql->SqlEscapeArg($_POST['rs_fax'][$id]),
	        "rs_remark"=>$booking->sql->SqlEscapeArg($_POST['rs_remark'][$id]),
	        "rs_names"=>$booking->sql->SqlEscapeArg($_POST['rs_names'][$id]),
	    );
	} else {
	    $result=array(
			"rs_id"=>$id,
	        "date_id"=>$_POST['date_id'][$id],
	        "rs_lastname"=>$_POST['rs_lastname'][$id],
	        "rs_firstname"=>$_POST['rs_firstname'][$id],
	        "rs_company"=>$_POST['rs_company'][$id],
	        "rs_places"=>$_POST['rs_places'][$id],
	        "rs_coupon"=>str_replace(" ","",$_POST['rs_coupon'][$id]),
	        "rs_street"=>$_POST['rs_street'][$id],
	        "rs_city"=>$_POST['rs_city'][$id],
	        "rs_email"=>$_POST['rs_email'][$id],
	        "rs_phone"=>$_POST['rs_phone'][$id],
	        "rs_fax"=>$_POST['rs_fax'][$id],
	        "rs_remark"=>$_POST['rs_remark'][$id],
	        "rs_names"=>$_POST['rs_names'][$id],
	        "val_rs_lastname"=>"rs_lastname_".$id,
	        "val_rs_firstname"=>"rs_firstname_".$id,
	        "val_rs_places"=>"rs_places_".$id,
	        //"val_rs_coupons"=>"rs_coupons_".$id,
	        "val_rs_street"=>"rs_street_".$id,
	        "val_rs_city"=>"rs_city_".$id,
	        "val_rs_email"=>"rs_email_".$id,
		);
    }
    return $result;
}

function setBooleanField($field,$boolean) {
    global $booking;
    $b=intval($boolean);
    $sql="UPDATE ".PREFIX.TABLENAME." SET ".$field."='".$b."' WHERE ".getWhereIdAddition();
    $ok=$booking->sql->DB->Execute($sql);
        if (!$ok) {
              $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
              $booking->tpl->assign("include","error.tpl");
    } else {
          	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
          	$booking->tpl->assign("redir","list_bookings.php");
          	$booking->tpl->assign("include","hinweis.tpl");
    }
}

function setBooleanFieldWithTime($field,$timefield,$boolean) {
    global $booking;
    $b=intval($boolean);
    $sql="UPDATE ".PREFIX.TABLENAME." SET ".$field."='".$b."',".$timefield."=NOW() WHERE ".getWhereIdAddition();
    $ok=$booking->sql->DB->Execute($sql);
        if (!$ok) {
              $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
              $booking->tpl->assign("include","error.tpl");
    } else {
          	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
          	$booking->tpl->assign("redir","list_bookings.php");
          	$booking->tpl->assign("include","hinweis.tpl");
    }
}

$booking->tpl->assign("formname",TABLENAME);

switch($_action) {
	case 'delete':
	        $sql="DELETE FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME."='".intval($_POST[ITEMIDNAME])."'";
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim L&ouml;schen der Reservierung."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Reservierung gel&ouml;scht. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'update':
	        // bearbeiten
	        
	        // alte daten auslesen
		    $sql="SELECT date_id,rs_places FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME."='".intval($_POST[ITEMIDNAME])."'";
		    $old=$booking->sql->DB->GetRow($sql);
		    //
	        $sql=array();
	        $querydata=$booking->sql->preparePostData(TABLENAME);
	        foreach($querydata['fields'] as $value) {
				$sql[]=$value."=".$querydata['values'][$value];
			}
			$sql="UPDATE ".PREFIX.TABLENAME." SET ".implode(",",$sql)." WHERE ".ITEMIDNAME." = '".intval($_POST[ITEMIDNAME])."'";
			$ok=$booking->sql->DB->Execute($sql);
		    // wurde die platzanzahl oder der termin veraendert?
		    if(intval($old['rs_places'])!=intval($_POST['rs_places']) || intval($old['date_id'])!=intval($_POST['date_id'])) {
				recalcFreePlaces();
		    }
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim &Auml;ndern des Reservierung."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Reservierung aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'submit':
	        // hinzufuegen
	        $querydata=$booking->sql->preparePostData(TABLENAME);
		    $fields=implode(",",$querydata['fields']);
		    $values=implode(",",$querydata['values']);
		    //$sql="SELECT MAX(RIGHT(rs_book_nr,6))+1 FROM ".PREFIX.TABLENAME."";
		    //$booknummer=intval(file_get_contents("booknbr.txt"))+1; //$booking->sql->DB->GetOne($sql);
            $sql="INSERT INTO ".PREFIX.TABLENAME." (".$fields.",rs_date) VALUES (".$values.",NOW())";
	        $ok1=$booking->sql->DB->Execute($sql);
	        $insertid=$booking->sql->DB->Insert_ID();
	        // ref.nr setzen
		    $booknbr=date("y")."-".str_pad($insertid,6,"0", STR_PAD_LEFT);
            $sql="UPDATE ".PREFIX.TABLENAME." SET rs_book_nr='".$booking->sql->SqlEscapeArg($booknbr)."' WHERE date_id = '".intval($_POST['date_id'])."'";
	        $ok=$booking->sql->DB->Execute($sql);
			// dates updaten, freie plaetze abziehen
			$sql="UPDATE ".PREFIX."dates SET st_capacity_act = st_capacity_act - ".intval($_POST['rs_places'])." WHERE date_id = '".intval($_POST['date_id'])."'";
	        $ok2=$booking->sql->DB->Execute($sql);
	        if (!$ok1 || !$ok2) {
                $booking->tpl->assign("error","Fehler beim Hinzuf&uuml;gen der Reservierung."); //  <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				//file_put_contents("booknbr.txt",$booknummer);
				/*
				if($insertid) {
					$coupons=explode(",",str_replace(" ","",$_POST['rs_coupons']));
					foreach($coupons as $nr) {
						$sql="UPDATE ".PREFIX."coupons SET cp_rs_id='".intval($insertid)."', cp_usedate='".time()."' WHERE cp_nr = '".$booking->sql->SqlEscapeArg($nr)."'";
						$ok=$booking->sql->DB->Execute($sql);
					}
				}
				*/
            	$booking->tpl->assign("hinweis","Reservierung hinzugef&uuml;gt. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'edit':
			$reserv=getBookingById($_GET['id']);
			//$usedcoupons=getUsedCouponsById($_GET['id']);
	        $booking->tpl->assign($reserv);
	        //$booking->tpl->assign("usedcoupons",$usedcoupons);
	case 'invalidformdata':
			if(!empty($_POST)) $booking->tpl->assign($_POST);
			//if(!empty($_SESSION['invalidcoupon'])) $booking->tpl->assign("invalidcoupon",$_SESSION['invalidcoupon']);
	case 'add':
			if($_action=="edit") {
		        $booking->tpl->assign("dates",getDatesAsOptions("OR date_id = '".intval($reserv['date_id'])."'"));
			} else {
		        $booking->tpl->assign("dates",getDatesAsOptions());
		        $booking->tpl->assign("addnew","true");
			}
	        $booking->tpl->assign("editmode","single");
            $booking->tpl->assign("include","booking_reserv_form.tpl");
            // Validierung
            if($_action=="add" || $_action=="edit") {
            	SmartyValidate::register_validator('rs_lastname', 'rs_lastname', 'notEmpty', false, false, 'trim');
            	SmartyValidate::register_validator('rs_firstname', 'rs_firstname', 'notEmpty', false, false, 'trim');
            	SmartyValidate::register_validator('rs_places', 'rs_places:date_id:rs_id', 'freePlaces', false, false, 'trim');
            	//SmartyValidate::register_validator('rs_coupons', 'rs_coupons', 'isValidCoupon', true, false, 'trim');
            	SmartyValidate::register_validator('rs_street', 'rs_street', 'notEmpty', false, false, 'trim');
            	SmartyValidate::register_validator('rs_city', 'rs_city', 'notEmpty', false, false, 'trim');
            	SmartyValidate::register_validator('rs_email', 'rs_email', 'isEmail', true, false, 'trim');
            }
	        break;
	case 'view':
	     analyzeCoupons(); // Coupons pruefen
	        // Liste anzeigen
			$sql="SELECT r.rs_id, DATE_FORMAT(r.rs_date,'%d.%m.%Y') AS rs_date_format, d.eventname, r.rs_firstname, r.rs_lastname, r.rs_email, r.rs_street, r.rs_city, r.rs_phone, r.rs_fax, r.rs_places,r.rs_coupon_nr, r.rs_calc_send, r.rs_calc_paid, r.rs_book_nr, r.rs_confirm_send,r.rs_participantinfos_send,r.rs_announceconfirm_send,r.rs_announceconfirm_recv,r.rs_company,r.rs_invoice_nbr,r.rs_has_invalid_coupons,DATE_FORMAT(r.rs_calc_senddate,'%d.%m.%Y um %H:%i Uhr') AS rs_calc_senddate_format,DATE_FORMAT(r.rs_calc_date,'%d.%m.%Y um %H:%i Uhr') AS rs_calc_date_format,DATE_FORMAT(r.rs_participantinfos_date,'%d.%m.%Y um %H:%i Uhr') AS rs_participantinfos_date_format,DATE_FORMAT(r.rs_announceconfirm_senddate,'%d.%m.%Y um %H:%i Uhr') AS rs_announceconfirm_senddate_format,DATE_FORMAT(r.rs_announceconfirm_recvdate,'%d.%m.%Y um %H:%i Uhr') AS rs_announceconfirm_recvdate_format,d.date_id,DATE_FORMAT(d.dt_date,'%d.%m.%Y') AS t_datum,DATE_FORMAT(d.dt_time,'%H:%i Uhr') AS t_uhrzeit,p.*,t.tr_designation FROM ".PREFIX."reserv r JOIN ".PREFIX."dates d ON r.date_id = d.date_id JOIN ".PREFIX."places p ON d.place_id = p.place_id JOIN ".PREFIX."trainings t ON d.training_id = t.training_id ".$_where." ORDER BY ".$sortfields[$_sortfield]." ".$sorttypes[$_sorttype]." ".$_limit;
			//echo "<!-- SQL: $sql -->\n";
			$reserv=$booking->sql->DB->GetAll($sql);
            $booking->tpl->assign("reserv_maxlen",getMaxLengths($reserv));
            $booking->tpl->assign("reservierungen",$reserv);
            $booking->tpl->assign("include","booking_reserv.tpl");
        	break;
    case 'multiinvalidformdata':
    		// TODO so geht das doch nich...
			if(!empty($_POST)) {
				$postreserv=array();
				foreach($_POST['reserv'] as $key=>$value) {
					$postreserv[]=prepareReservByPostId($key,false);
				}
				$booking->tpl->assign("reservierungen",$postreserv);
	        	//echo "<!-- "; print_r($postreserv); echo " -->";
			}
    case 'multiedit':
    		// TODO auf eine einzelne query umbauen?
    		$reservierungen=array();
    		$dateids=array();
    		foreach($_POST['reserv'] as $key=>$value) {
    			$reserv=getBookingById($key);
        		$dateids[]=intval($reserv['date_id']);
	        	if($_action!="multiinvalidformdata") {
	    			$reserv['val_rs_lastname']="rs_lastname_".$reserv['rs_id'];
	    			$reserv['val_rs_firstname']="rs_firstname_".$reserv['rs_id'];
	    			$reserv['val_rs_places']="rs_places_".$reserv['rs_id'];
	    			//$reserv['val_rs_coupons']="rs_coupons_".$reserv['rs_id'];
	    			$reserv['val_rs_street']="rs_street_".$reserv['rs_id'];
	    			$reserv['val_rs_city']="rs_city_".$reserv['rs_id'];
	    			$reserv['val_rs_email']="rs_email_".$reserv['rs_id'];
	        	}
		        $reservierungen[]=$reserv;
	            // Validierung
	            if($_action=="multiadd" || $_action=="multiedit") {
	            	SmartyValidate::register_validator('rs_lastname_'.$key, 'rs_lastname['.$key.']', 'notEmpty', false, false, 'trim');
	            	SmartyValidate::register_validator('rs_firstname_'.$key, 'rs_firstname['.$key.']', 'notEmpty', false, false, 'trim');
	            	SmartyValidate::register_validator('rs_places_'.$key, 'rs_places['.$key.']:date_id['.$key.']:reserv['.$key.']', 'freePlaces', false, false, 'trim');
	            	//SmartyValidate::register_validator('rs_coupons_'.$key, 'rs_coupons['.$key.']', 'isValidCoupon', true, false, 'trim');
	            	SmartyValidate::register_validator('rs_street_'.$key, 'rs_street['.$key.']', 'notEmpty', false, false, 'trim');
	            	SmartyValidate::register_validator('rs_city_'.$key, 'rs_city['.$key.']', 'notEmpty', false, false, 'trim');
	            	SmartyValidate::register_validator('rs_email_'.$key, 'rs_email['.$key.']', 'isEmail', true, false, 'trim');
	            }
    		}
    		$booking->tpl->assign("dates",getDatesAsOptions("OR date_id = '".implode("' OR date_id = '",$dateids)."'"));
			if($_action!="multiinvalidformdata") {
	        	$booking->tpl->assign("reservierungen",$reservierungen);
	        	//echo "<!-- "; print_r($reservierungen); echo " -->";
			}
	        $booking->tpl->assign("editmode","multi");
            $booking->tpl->assign("include","booking_reserv_form.tpl");
    		break;
	case 'multidel':
			$sql="DELETE FROM ".PREFIX.TABLENAME." WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim L&ouml;schen der Reservierungen."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Reservierungen gel&ouml;scht. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multiconfirm':
			$sql="UPDATE ".PREFIX.TABLENAME." SET rs_confirm_send='1',rs_confirm_date=NOW() WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multimarkaspayed':
			$sql="UPDATE ".PREFIX.TABLENAME." SET rs_calc_paid='1',rs_calc_date=NOW() WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
			
			/* inserted by flobo 16.07.2005 */
			include("send_message.php");
			
			
    		break;
	case 'multimarkasnotpayed':
			$sql="UPDATE ".PREFIX.TABLENAME." SET rs_calc_paid='0' WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multimarkassent':
			$sql="UPDATE ".PREFIX.TABLENAME." SET rs_calc_send='1',rs_calc_senddate=NOW() WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
			// Rechnungsnummern speichern
			foreach($_POST['reserv'] as $key=>$value) {
				if($_POST['invoicenbr'][$key]) {
					$sql="UPDATE ".PREFIX.TABLENAME." SET rs_invoice_nbr='".$booking->sql->SqlEscapeArg($_POST['invoicenbr'][$key])."' WHERE ".ITEMIDNAME."=".intval($key)."";
					$ok=$booking->sql->DB->Execute($sql);
				}
			}
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multimarkasnotsent':
			$sql="UPDATE ".PREFIX.TABLENAME." SET rs_calc_send='0',rs_invoice_nbr=NULL WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Aktualisieren der Reservierungen."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_bookings.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;

	case 'multimarkparticipantinfossend':
	      setBooleanFieldWithTime("rs_participantinfos_send","rs_participantinfos_date",true);
    		break;
	case 'multimarkparticipantinfosnotsend':
	      setBooleanField("rs_participantinfos_send",false);
    		break;
	case 'multimarkannounceconfirmsend':
	      setBooleanFieldWithTime("rs_announceconfirm_send","rs_announceconfirm_senddate",true);
    		break;
	case 'multimarkannounceconfirmnotsend':
	      setBooleanField("rs_announceconfirm_send",false);
    		break;
	case 'multimarkannounceconfirmrecv':
	      setBooleanFieldWithTime("rs_announceconfirm_recv","rs_announceconfirm_recvdate",true);
    		break;
	case 'multimarkannounceconfirmnotrecv':
	      setBooleanField("rs_announceconfirm_recv",false);
    		break;

	case 'multiupdate':
			foreach($_POST['reserv'] as $key=>$value) {
				$data=prepareReservByPostId($key,true);
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
	                $booking->tpl->assign("error","Fehler beim &Auml;ndern der Reservierungen."); // <!-- $sql -->
	                $booking->tpl->assign("include","error.tpl");
				} else {
					recalcFreePlaces();
	            	$booking->tpl->assign("hinweis","Reservierungen aktualisiert. Bitte warten...");
	            	$booking->tpl->assign("redir","list_bookings.php");
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
