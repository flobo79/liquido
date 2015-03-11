<?
require_once("header.inc.php");

switch($_action) {
	case 'view':
  default:
      $sql="SELECT DISTINCT DATE_FORMAT(d.dt_date,'%Y') AS id,DATE_FORMAT(d.dt_date,'%Y') AS jahr FROM ".PREFIX."dates d ORDER BY d.dt_date ASC";
      $jahre=$booking->sql->DB->GetAssoc($sql);
      
      $monate=array(
        "1" => "Januar",
        "2" => "Feburar",
        "3" => "M&auml;rz",
        "4" => "April",
        "5" => "Mai",
        "6" => "Juni",
        "7" => "Juli",
        "8" => "August",
        "9" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Dezember",
      );

    	$booking->tpl->assign("monate",$monate);
    	$booking->tpl->assign("monat",date("n"));
    	$booking->tpl->assign("jahre",$jahre);
    	$booking->tpl->assign("jahr",date("Y"));
    	//$booking->tpl->assign("include","statistiken.tpl");
    	$booking->tpl->assign("include","statistiken-sample.tpl");
    	break;
}

$booking->output("main.tpl");
?>
