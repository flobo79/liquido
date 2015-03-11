<?php

/* FIREPHP SETUP */
require_once($_SERVER['DOCUMENT_ROOT']."/liquido/lib/FirePHPCore/fb.php");
require_once($_SERVER['DOCUMENT_ROOT']."/liquido/lib/init.php");
include_once 'ofc-library/open_flash_chart_object.php';
 

class Mikos_stats extends Sprite {
	public $month;
	public $year;
	public $day;
	
	public function __construct($type='kis',$month=false, $day = false, $year = false) {
		$this->Sprite();
		
		//include(dirname(dirname(dirname(__FILE__)))."/lib/init.php");
		include($_SERVER['DOCUMENT_ROOT']."/mikos/config.inc.php");
		
		global $smarty;
		global $db;
		
		
		//$this->smarty = $smarty;
		$this->db = ADONewConnection(LOCALDBTYPE);
		$this->db->debug = false;
		$this->db->Connect(LOCALDBHOST, LOCALDBUSER, LOCALDBPASS, LOCALDBNAME);
		
		$this->type = $type;
		$this->month = date("m");
		$this->year = date("y");
		$this->day = date("d");
	}
	
	public function getMonth() {
		
		$list = array();
		$highest = 0;
		for($d=1; date("m",$day = mktime(0,0,0,date("m"),$d,$this->year)) == $this->month; $d++) {
			$day = $this->db->getOne("select count(timestamp) as num from login_protocoll where `type` = '".$this->type."' and `timestamp` between $day and ".mktime(0,0,0,date("m"),$d+1,$this->year));
			
			if($day > $highest) $highest = $day;
			$list[] = $day;
		}
		return array('list' => $list, "highest" => $highest);
	}
	
	
	public function getYear() {
		$list = array();
		$max = 0;
		
		$y = date('Y');
		for($m=1; date("Y", $month = mktime(0,0,0,$m,1,$y)) == $y; $m++) {
			$month = $this->db->getOne("select count(timestamp) as num from login_protocoll where `type` = '".$this->type."' and `timestamp` between $month and ".mktime(0,0,0,$m+1,1,$this->year));
			if($month > $highest) $highest = $month;
			$list[] = $month;
		}
		return array('list' => $list, "highest" => $highest);
	}
	
	
	
	public function getDay() {
		$list = array();
		$max = 0;
		$to = mktime(0,0,0,$this->month,$this->day,$this->year);
		for($h=0; $h<24; $h++) {
			$from = $to;
			$to = $from + $h * 3600;
			
			$hour = $this->db->getOne("select count(timestamp) as num from login_protocoll where `type` = '".$this->type."' and `timestamp` between $from and $to");
			if($hour > $highest) $highest = $hour;
			$list[] = $hour;
		}
		return array('list' => $list, "highest" => $highest);
	}
	
	
	public function getLoginsByUser() {
		$from = mktime(0,0,0,$this->month,1,$this->year);
		$till = mktime(0,0,0,$this->month+1,1,$this->year);
		
		if($this->type == 'cpis') {
			$sql = "select count(BNR) as logins, BNR  from login_protocoll where type='cpis' and `timestamp` between $from and $till group by BNR order by logins desc";
		} elseif ($this->type == 'kis') {
			$sql = "select count(ID) as logins, ID, memberNumber from login_protocoll where type='kis' and `timestamp` between $from and $till group by ID order by logins desc";
		}
		
		return $this->db->getAll($sql);		
	}
	
	public function getLoginsByMonth() {
		$from = mktime(0,0,0,$this->month,1,$this->year);
		$till = mktime(0,0,0,$this->month+1,1,$this->year);
		
		if($this->type == 'cpis') {
			$sql = "select BNR, FROM_UNIXTIME(timestamp,'%d.%m.%y %h:%i:%s') as Zeitpunkt from login_protocoll where type='cpis' and `timestamp` between $from and $till order by `timestamp`";
		} elseif ($this->type == 'kis') {
			$sql = "select ID, memberNumber, FROM_UNIXTIME(timestamp,'%d.%m.%y %h:%i:%s') as Zeitpunkt from login_protocoll where type='kis' and `timestamp` between $from and $till order by `timestamp`";
		}
		
		return $this->db->getAll($sql);		
	}
}





$stats = new Mikos_stats();
$stats->getLoginsByUser();

if(isset($_GET['ajax'])) {

	$type = (isset($_GET['type']) && $_GET['type'] == 'kis') ? 'kis' : 'cpis';
	$stats->type=$type;
	
	
	// loading Data
	if(ereg("^get",$_GET['ajax'])) {
		// use the chart class to build the chart:
		include_once( 'ofc-library/open-flash-chart.php' );
		
		switch($_GET['ajax']) {	
			
			case 'getDay':		
				$data = $stats->getDay();
				$g_title = strtoupper($stats->type).' Logins heute nach Stunden';			
				$g_tooltip = '#val#';
				$g_data = $data['list'];
				$g_labels_x = array();
				for($l=1;$l<=24;$l++) {  $g_labels_x[] = $l; }
				$g_max = $data['highest']+10;
				break;
			
			case 'getMonth':
				$data = $stats->getMonth();
				$g_title = strtoupper($stats->type).' Logins pro Tag '. date("M")." ".date("Y");
				$g_data = $data['list'];
				$g_tooltip = '#val# logins am<br>#x_label#.'.$stats->month.".";
				$length = count($data['list']);
				$g_labels_x = array();
				for($l=1;$l<=$length;$l++) {  $g_labels_x[] = $l; }
				$g_max = $data['highest']+10;
				break;
			
			case 'getYear':
				// get Data		
				$data = $stats->getYear();
				$g_data = $data['list'];
				$g_title = 'Logins pro Monat in '.date("Y",mktime(0,0,1,$stats->month,$stats->day,$stats->year));
				$g_tooltip = '#val# logins <br>im #x_label#';
				$g_max = $data['highest']+10;
				$g_labels_x = array( 'Jan', 'Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov', 'Dez' );
	
				break;
		}
	
		$g = new graph();
		$g->title($g_title, '{font-size:14px; color: #666666; margin:10px; padding: 5px 15px 5px 15px;}' );			
		$g->set_tool_tip($g_tooltip);
		$g->set_data($g_data);
		$g->bg_colour = '#FDFDFD';
		$g->set_x_labels($g_labels_x);
		$g->set_y_max($g_max);
		$g->y_label_steps( 2 );
		$g->x_axis_colour( '#e0e0e0', '#e0e0e0' );
		$g->y_axis_colour( '#e0e0e0', '#e0e0e0' );
	
		echo $g->render();
	
	
	// if a download request has been sent (ajax trigger abused ;-))
	} elseif (ereg("^download",$_GET['ajax'])) {
		$req = $_GET;
		// check if all data has been sent
		if(isset($req['month']) && intval($req['month'])) $stats->month = $req['month'];
		if(isset($req['year']) && intval($req['year'])) $stats->year = $req['year'];
				
		switch($req['ajax']) {
			case 'downloadUserCSV':
				$rs = $stats->getLoginsByUser();
				$filename = strtoupper($stats->type).'_logins_nach_benutzer_'.$stats->month.$stats->year.'.csv';
				
				break;
				
			case "downloadLoginCSV":
				$rs = $stats->getLoginsByMonth();
				$filename = strtoupper($stats->type).'_logins_nach_monat_'.$stats->month.$stats->year.'.csv';
				
				break;
		}
		
		if(is_array($rs)) {
			$getheadrow = array();
			$headrow = false;
			foreach($rs as $entry) {
				// strip unsigned array fields
				foreach($entry as $k => $v) { 
					if(intval($k) || $k == '0') {
						unset($entry[$k]);
					} else {
						if(!$headrow) $getheadrow[]=$k;
						$entry[$k] = '"'.addslashes($v).'"';
					}
				}
				$headrow = true;
				$str_list .= implode(";",$entry)."\n";
			}
			
			header("Content-Type: application/octet-stream");
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			echo '"'.implode('";"',$getheadrow)."\"\n";
			echo $str_list;
				
		} else {
			echo "CSV konnte nicht erstellt werden.";
		}
	}	
	
} else {

?>
<html>
<head>
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<title>Mikos Statistik</title>
<style type="text/css">
	.section { font-weight:bold; color:#999; font-size:14px; margin-bottom:10px; margin-top:25px; font-family:Verdana, Geneva, Arial, Helvetica, sans-serif; }
	.col { float:left; width: 420px; }
	.download { padding-left:20px; line-height:18px; cursor:pointer; background:url(download.gif) no-repeat transparent; margin-bottom:5px;}
</style>


</head>
<body style="font-family: verdana; font-size: 12px;">


<div class="col">
	<div class="section">Club Partner Informations System</div>
	
	<div id="cpis_year">
	<?php open_flash_chart_object( 400 , 150, $_SERVER['SCRIPT_NAME'].'?ajax=getYear&type=cpis', false ); ?>
	</div>
	
	<div id="cpis_month">
	<?php open_flash_chart_object( 400, 150, $_SERVER['SCRIPT_NAME'].'?ajax=getMonth&type=cpis', false ); ?>
	</div>
	
	<div id="cpis_month">
	<?php open_flash_chart_object( 400, 150, $_SERVER['SCRIPT_NAME'].'?ajax=getDay&type=cpis', false ); ?>
	</div>
	
	<div class="download" onclick="document.location.href='start.php?ajax=downloadUserCSV&type=cpis&'">download BNR-Login-Statistik für aktuellen Monat</div>
	<div class="download" onclick="document.location.href='start.php?ajax=downloadLoginCSV&type=cpis&'">download Login-Statistik für aktuellen Monat</div>
</div>

<div class="col">
	<div class="section">Kunden Informations System</div>
	
	<div id="cpis_year">
	<?php open_flash_chart_object( 400 , 150, $_SERVER['SCRIPT_NAME'].'?ajax=getYear&type=kis', false ); ?>
	</div>
	
	<div id="cpis_month">
	<?php open_flash_chart_object( 400, 150, $_SERVER['SCRIPT_NAME'].'?ajax=getMonth&type=kis', false ); ?>
	</div>
	
	<div id="cpis_month">
	<?php open_flash_chart_object( 400, 150, $_SERVER['SCRIPT_NAME'].'?ajax=getDay&type=kis', false ); ?>
	</div>
	<div class="download" onclick="document.location.href='start.php?ajax=downloadUserCSV&type=kis&'">download Member-Login-Statistik für aktuellen Monat</div>
	<div class="download" onclick="document.location.href='start.php?ajax=downloadLoginCSV&type=kis&'">download Login-Statistik für aktuellen Monat</div>

</div>
</body></html>
<?php } ?>
