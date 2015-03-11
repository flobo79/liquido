<?
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

require_once("config.inc.php");

session_start();

//require_once("checkpost.inc.php");

class Booking_SQL {
	var $DB;

    function Booking_SQL() {
		$this->DB = ADONewConnection(DBTYPE);
		$this->DB->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		if (!$this->DB) die("Systemfehler!");
		$this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
	}

	function Disconnect() {
		$this->DB->Close();
	}

	function SqlEscapeArg($string,$dbtype=DBTYPE)
	{
	    if($dbtype == "mysql") {
	        return mysql_escape_string($string);
	    } elseif($dbtype == "postgres" || $dbtype == "postgres7") {
	        return pg_escape_string($string);
	    } else {
	        return addslashes($string);
	    }
	}
	
	/*
	Escaped einen Array wie $_POST und $_GET für SQL Abfragen
	*/
	function castUserData($data) {
		$result = array();
		foreach ($data as $key => $value) {
		  $arr = explode("_",$key,1);
		  if(count($arr) == 2 && strlen($arr[0]) == 1) {
			  // $arr[0] enthällt dann s / i / f / ... und $arr[1] den varnamen
			  if($arr[0]=="i") {
			    $result[$key] = intval($value);
			  } else if($arr[0]=="f") {
			    $result[$key] = floatval(str_replace(",",".",$value));
			  } else {
			    $result[$key] = $this->SqlEscapeArg($value);
			  }
		  } else {
		    $result[$key] = $this->SqlEscapeArg($value);
		  }
		}
	}
	
//	function prepareData(&$PD,&$GD) {
//		if($_POST) {
//			$PD=$this->castUserData($_POST);
//		}
//		if($_GET) {
//			$GD=$this->castUserData($_GET);
//		}
//	}
	function preparePostData($table) {
		$result = array();
	    $data=array();
	    switch($table) {
	    	case "dates":
			    $data['place_id']="'".intval($_POST['place_id'])."'";
			    $data['dt_date']="'".$this->SqlEscapeArg($_POST['Date_Year'])."-".$this->SqlEscapeArg($_POST['Date_Month'])."-".$this->SqlEscapeArg($_POST['Date_Day'])."'";
			    $data['dt_time']="'00000000".$this->SqlEscapeArg($_POST['Time_Hour']).$this->SqlEscapeArg($_POST['Time_Minute'])."00'";
			    $data['training_id']="'".intval($_POST['training_id'])."'";


//neu hinzu für eventname
  				$data['eventname']="'".$this->SqlEscapeArg($_POST['eventname'])."'";
  				$data['eventdetails']="'".$this->SqlEscapeArg($_POST['eventdetails'])."'";

			    $data['dt_capacity_max']="'".intval($_POST['dt_capacity_max'])."'";
			    // TODO siehe list_dates.php, da stehts ebenfalls...
			    if($_POST['dt_frei']=="j") {
			    	// ja = 1
			    	$data['dt_frei']="'1'";
			    }
			    else if($_POST['dt_frei']=="b") {
			    	// beschraenkt = 2
			    	$data['dt_frei']="'2'";
			    }
			    else {
			    	// nein = 0
			    	$data['dt_frei']="'0'";
			    }
	    		break;
	    	case "places":
			    $data['pl_name']="'".$this->SqlEscapeArg($_POST['pl_name'])."'";
			    $data['pl_street']="'".$this->SqlEscapeArg($_POST['pl_street'])."'";
			    $data['pl_zipcode']="'".$this->SqlEscapeArg($_POST['pl_zipcode'])."'";
			    $data['pl_city']="'".$this->SqlEscapeArg($_POST['pl_city'])."'";
			    $data['country_id']="'".intval($_POST['country_id'])."'";
	    		break;
	    	case "reserv":
			    $data['date_id']="'".intval($_POST['date_id'])."'";
			    $data['rs_lastname']="'".$this->SqlEscapeArg($_POST['rs_lastname'])."'";
			    $data['rs_firstname']="'".$this->SqlEscapeArg($_POST['rs_firstname'])."'";
			    $data['rs_company']="'".$this->SqlEscapeArg($_POST['rs_company'])."'";
			    $data['rs_places']="'".intval($_POST['rs_places'])."'";
			    if($_POST['rs_coupon']) {
            $data['rs_coupon']="'".$this->SqlEscapeArg($_POST['rs_coupon'])."'";
            $data['rs_coupon_nr']="'".count(explode(",",str_replace(" ","",$_POST['rs_coupon'])))."'";
          } else {
            $data['rs_coupon']="''";
            $data['rs_coupon_nr']="'0'";
          }
			    $data['rs_street']="'".$this->SqlEscapeArg($_POST['rs_street'])."'";
			    $data['rs_city']="'".$this->SqlEscapeArg($_POST['rs_city'])."'";
			    $data['rs_email']="'".$this->SqlEscapeArg($_POST['rs_email'])."'";
			    $data['rs_phone']="'".$this->SqlEscapeArg($_POST['rs_phone'])."'";
			    $data['rs_fax']="'".$this->SqlEscapeArg($_POST['rs_fax'])."'";
			    $data['rs_remark']="'".$this->SqlEscapeArg($_POST['rs_remark'])."'";
			    $data['rs_names']="'".$this->SqlEscapeArg($_POST['rs_names'])."'";
	    		break;
	    	default:
	    		break;
	    }
	    $fields=array();
	    foreach($data as $key=>$value) $fields[]=$this->SqlEscapeArg($key);
	    $result['fields']=$fields;
	    $result['values']=$data;
	    return $result;
	}
}

class Booking_Smarty extends Smarty {
    function Booking_Smarty() {
		$this->template_dir = COMPONENT_DIR.'templates/';
		$this->compile_dir = COMPONENT_DIR.'templates_c/';
		$this->config_dir = COMPONENT_DIR.'configs/';
		$this->plugins_dir[0] = COMPONENT_DIR.'plugins';
		$this->plugins_dir[1] = SMARTY_DIR.'plugins';

		$this->compile_check = true;
	}
}

class Booking {

    // database object
    var $sql = null;
    // smarty template object
    var $tpl = null;
    // error messages
    var $error = null;

    function Booking() {
        $this->sql =& new Booking_SQL;
        $this->tpl =& new Booking_Smarty;
    }

	function output($template) {
    //session_write_close();
		$this->tpl->display($template);
		$this->sql->Disconnect();
		global $time_start;
		$time_end = microtime_float();
		$time = $time_end - $time_start;
		echo "<!-- $time sec -->";
	}
}

/*
Erwartet einen ADODB GetAll Array und gibt die längsten Inhalte zurück
*/
function getMaxLengths($array) {
	$result = array();
	if(is_array($array)) {
		foreach($array as $nbr => $value) {
			foreach($value as $key => $subvalue) {
	            if(strlen($subvalue) == max(strlen($result[$key]),strlen($subvalue))) {
					$result[$key] = $subvalue;
				}
			}
		}
	}
	return $result;
}

if(!function_exists('file_get_contents')) {
   function file_get_contents($file) {
       $file = file($file);
       return !$file ? false : implode('', $file);
   }
}

if(!function_exists('file_put_contents')) {
  function file_put_contents($filename, $data, $file_append = false) {
   $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
   if(!$fp) {
     trigger_error('file_put_contents cannot write in file.', E_USER_ERROR);
     return;
   }
   fputs($fp, $data);
   fclose($fp);
  }
}

function debug($var) {
	//echo "<!-- "; print_r($var); echo " -->\n";
}

function recalcFreePlaces() {
	global $booking;
	// dates updaten, freie plaetze neu berechnen
	$sql="DROP TABLE IF EXISTS ".PREFIX."usedplaces";
	$ok=$booking->sql->DB->Execute($sql);
	$sql="CREATE TEMPORARY TABLE ".PREFIX."usedplaces SELECT d.date_id,d.dt_capacity_max-SUM(r.rs_places) AS freeplaces FROM ".PREFIX."dates d JOIN ".PREFIX."reserv r ON d.date_id=r.date_id GROUP BY r.date_id";
	$ok=$booking->sql->DB->Execute($sql);
	if(!$ok) die("Datenbankfehler recalcFreePlaces()");
	$sql="UPDATE ".PREFIX."dates SET st_capacity_act = dt_capacity_max";
	$ok=$booking->sql->DB->Execute($sql);
	if(!$ok) die("Datenbankfehler recalcFreePlaces()");
	$sql="UPDATE ".PREFIX."dates d JOIN ".PREFIX."usedplaces u ON d.date_id=u.date_id SET d.st_capacity_act = u.freeplaces WHERE d.date_id = u.date_id";
	$ok=$booking->sql->DB->Execute($sql);
	if(!$ok) die("Datenbankfehler recalcFreePlaces()");
}

$booking = & new Booking;

// aktuelle Action
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

// URL Query Zusatz
$query = array_merge($_GET);
unset($query['sort']);
unset($query['type']);
$querystring="";
foreach($query as $key => $value) $querystring.="&$key=$value";
$booking->tpl->assign("query",$querystring);

// Tabellenbreite
$booking->tpl->assign("tablewidth","100%");

//echo "<!-- SESSION: "; print_r($_SESSION); echo " -->\n";
//echo "<!-- POST: "; print_r($_POST); echo " -->\n";
//echo "<!-- GET: "; print_r($_GET); echo " -->\n";
//echo "<!-- REQUEST: "; print_r($_REQUEST); echo " -->\n";
//echo "<!-- action: $action -->\n";

?>
