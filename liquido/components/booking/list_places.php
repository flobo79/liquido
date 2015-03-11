<?
require_once("header.inc.php");

// Tabellenname ohne prefix
define("TABLENAME","places");

// Anfang der Datensaetze, default = 0
$_start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;

// Anzahl der Datensaetze, default = 30
$_perpage = isset($_REQUEST['perpage']) ? intval($_REQUEST['perpage']) : 30;

// Abfrage-Ergebnisse begrenzen?
$_limit = isset($_REQUEST['start']) ? "LIMIT ".$_start.",".$_perpage : "";

// Suchbegriff angegeben?
define("SEARCHMASK","WHERE p.pl_name LIKE '%%' OR p.pl_street LIKE '%%' OR p.pl_zipcode LIKE '%%' OR p.pl_city LIKE '%%' OR c.co_name LIKE '%%'");
$_where = isset($_REQUEST['searchterm']) ? str_replace("%%","%".$booking->sql->SqlEscapeArg($_REQUEST['searchterm'])."%",SEARCHMASK) : "";

// aktuelle Sortierungsspalte, default = Datum
$_sortfield = isset($_REQUEST['sort']) ? intval($_REQUEST['sort']) : 0;
$sortfields = array(
    "co_name", // 0
    "pl_name", // 1
    "pl_zipcode", // 2
);
$booking->tpl->assign("sort",$_sortfield);

// aktuelle Sortierungsreihenfolge
$_sorttype = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
$sorttypes = array(
    "asc",
    "desc"
);
$booking->tpl->assign("typeimg",'<img src="gfx/sort_'.$sorttypes[$_sorttype].'.gif" width="8" height="9" border="0" />');

$_urlsorttype = $_sorttype == 0 ? 1 : 0;
$booking->tpl->assign("sorturladd",$_urlsorttype);

// wird ein objekt bearbeitet?
define("ITEMIDNAME","place_id");
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

function getPlaceById($id) {
	global $booking;
    $sql="SELECT * FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME." = '".intval($id)."' LIMIT 0,1";
    return $booking->sql->DB->GetRow($sql);
}

function getCountries() {
    // Bundeslaender
    global $booking;
    $sql="SELECT * FROM ".PREFIX."countries ORDER BY co_name ASC";
    return $booking->sql->DB->GetAssoc($sql);
}

function getWhereIdAddition() {
	$result="";
	$i=0;
	foreach($_POST['places'] as $key=>$value) {
		$i++;
		$result.=ITEMIDNAME."='".intval($key)."'";
		if($i < count($_POST['places'])) $result.=" OR ";
	}
	return $result;
}

function preparePlaceByPostId($id, $forsql = false) {
	global $booking;
	$result=array();
	if($forsql) {
		$result=array(
	        "pl_name"=>$booking->sql->SqlEscapeArg($_POST['pl_name'][$id]),
	        "pl_street"=>$booking->sql->SqlEscapeArg($_POST['pl_street'][$id]),
	        "pl_zipcode"=>intval($_POST['pl_zipcode'][$id]),
	        "pl_city"=>$booking->sql->SqlEscapeArg($_POST['pl_city'][$id]),
	        "country_id"=>intval($_POST['country_id'][$id]),
	    );
	} else {
	    $result=array(
			"place_id"=>$id,
	        "pl_name"=>$_POST['pl_name'][$id],
	        "pl_street"=>$_POST['pl_street'][$id],
	        "pl_zipcode"=>$_POST['pl_zipcode'][$id],
	        "pl_city"=>$_POST['pl_city'][$id],
	        "country_id"=>$_POST['country_id'][$id],
	        "val_pl_name"=>"pl_name_".$id,
	        "val_pl_street"=>"pl_street_".$id,
	        "val_pl_zipcode"=>"pl_zipcode_".$id,
	        "val_pl_city"=>"pl_city_".$id,
		);
    }
    return $result;
}

$booking->tpl->assign("formname",TABLENAME);

switch($_action) {
	case 'delete':
	        $sql="DELETE FROM ".PREFIX.TABLENAME." WHERE ".ITEMIDNAME."='".intval($_POST[ITEMIDNAME])."'";
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim L&ouml;schen des Trainingsplatzes."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Trainingsplatz gel&ouml;scht. Bitte warten...");
            	$booking->tpl->assign("redir","list_places.php");
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
                $booking->tpl->assign("error","Fehler beim &Auml;ndern des Trainingsplatzes."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Trainingsplatz aktualisiert. Bitte warten...");
            	$booking->tpl->assign("redir","list_places.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'submit':
	        // hinzufuegen
	        $querydata=$booking->sql->preparePostData(TABLENAME);
		    $fields=implode(",",$querydata['fields']);
		    $values=implode(",",$querydata['values']);
            $sql="INSERT INTO ".PREFIX.TABLENAME." (".$fields.") VALUES (".$values.")";
	        $ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim Hinzuf&uuml;gen des Trainingsplatzes."); //  <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
            	$booking->tpl->assign("hinweis","Trainingsplatz hinzugef&uuml;gt. Bitte warten...");
            	$booking->tpl->assign("redir","list_places.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
	        break;
	case 'edit':
			$place=getPlaceById($_GET['id']);
	        $booking->tpl->assign($place);
	case 'invalidformdata':
			if(!empty($_POST)) $booking->tpl->assign($_POST);
	case 'add':
	        $booking->tpl->assign("countries",getCountries());
	        $booking->tpl->assign("editmode","single");
            $booking->tpl->assign("include","booking_places_form.tpl");
            // Validierung
            if($_action=="add" || $_action=="edit") {
            	SmartyValidate::register_validator('pl_name', 'pl_name', 'notEmpty', false, false, 'trim');
            	SmartyValidate::register_validator('pl_street', 'pl_street', 'notEmpty', false, false, 'trim');
            	SmartyValidate::register_validator('pl_zipcode', 'pl_zipcode', 'isInt', false, false, 'trim');
            	SmartyValidate::register_validator('pl_city', 'pl_city', 'notEmpty', false, false, 'trim');
            }
	        break;
	case 'view':
	        // Liste anzeigen
			$sql="SELECT p.place_id, p.pl_name, p.pl_street, p.pl_zipcode, p.pl_city, c.co_name FROM ".PREFIX."places p JOIN ".PREFIX."countries c ON p.country_id = c.country_id ".$_where." ORDER BY ".$sortfields[$_sortfield]." ".$sorttypes[$_sorttype].", p.pl_name ASC ".$_limit;
			//echo $sql;
			$places=$booking->sql->DB->GetAll($sql);
            //$booking->tpl->assign("places_maxlen",getMaxLengths($places));
            $booking->tpl->assign("places",$places);
            $booking->tpl->assign("include","booking_places.tpl");
        	break;
    case 'multiinvalidformdata':
			if(!empty($_POST)) {
				$postplaces=array();
				foreach($_POST['dates'] as $key=>$value) {
					$postplaces[]=preparePlaceByPostId($key,false);
				}
				$booking->tpl->assign("places",$postplaces);
	        	debug($postplaces);
			}
    case 'multiedit':
    		// TODO auf eine einzelne query umbauen?
	        $booking->tpl->assign("countries",getCountries());
    		$places=array();
    		foreach($_POST['places'] as $key=>$value) {
    			$place=getPlaceById($key);
    			if($_action!="multiinvalidformdata") {
	    			$place['val_pl_name']="pl_name_".$place['place_id'];
	    			$place['val_pl_street']="pl_street_".$place['place_id'];
	    			$place['val_pl_zipcode']="pl_zipcode_".$place['place_id'];
	    			$place['val_pl_city']="pl_city_".$place['place_id'];
    			}
		        $places[]=$place;
	            // Validierung
	            if($_action=="multiadd" || $_action=="multiedit") {
	            	SmartyValidate::register_validator('pl_name_'.$key, 'pl_name['.$key.']', 'notEmpty', false, false, 'trim');
	            	SmartyValidate::register_validator('pl_street_'.$key, 'pl_street['.$key.']', 'notEmpty', false, false, 'trim');
	            	SmartyValidate::register_validator('pl_zipcode_'.$key, 'pl_zipcode['.$key.']', 'isInt', false, false, 'trim');
	            	SmartyValidate::register_validator('pl_city_'.$key, 'pl_city['.$key.']', 'notEmpty', false, false, 'trim');
	            }
    		}
    		if($_action!="multiinvalidformdata") {
	        	$booking->tpl->assign("places",$places);
    		}
	        $booking->tpl->assign("editmode","multi");
            $booking->tpl->assign("include","booking_places_form.tpl");
    		break;
	case 'multidel':
			$sql="DELETE FROM ".PREFIX.TABLENAME." WHERE ".getWhereIdAddition();
			$ok=$booking->sql->DB->Execute($sql);
	        if (!$ok) {
                $booking->tpl->assign("error","Fehler beim L&ouml;schen der Trainingspl&auml;tze."); // <!-- $sql -->
                $booking->tpl->assign("include","error.tpl");
			} else {
				recalcFreePlaces();
            	$booking->tpl->assign("hinweis","Trainingspl&auml;tze gel&ouml;scht. Bitte warten...");
            	$booking->tpl->assign("redir","list_places.php");
            	$booking->tpl->assign("include","hinweis.tpl");
			}
    		break;
	case 'multiupdate':
			foreach($_POST['places'] as $key=>$value) {
				$data=preparePlaceByPostId($key,true);
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
	                $booking->tpl->assign("error","Fehler beim &Auml;ndern der Trainingspl&auml;tze."); // <!-- $sql -->
	                $booking->tpl->assign("include","error.tpl");
				} else {
	            	$booking->tpl->assign("hinweis","Trainingspl&auml;tze aktualisiert. Bitte warten...");
	            	$booking->tpl->assign("redir","list_places.php");
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
