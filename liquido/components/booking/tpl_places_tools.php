<?
require_once("config.inc.php");
$DB = ADONewConnection(DBTYPE);
$DB->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$DB) die("Systemfehler!");
$DB->SetFetchMode(ADODB_FETCH_ASSOC);
$sql="SELECT DISTINCT DATE_FORMAT(dt_date,'%M %Y') AS filter, DATE_FORMAT(dt_date,'%m') AS monat,DATE_FORMAT(dt_date,'%Y') AS jahr FROM ".PREFIX."dates ORDER BY dt_date DESC";
$options=$DB->GetAll($sql);
$DB->Close();
$month_names_de  = array("Januar","Feburar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
?>
<div id="booking_tools"> &nbsp; 
  <select name="from"  onchange="doaction(this.options[this.selectedIndex].value,this);">
    <option selected>Aktionen ...</option>
    <option value="multiedit">bearbeiten</option>
    <option value="multidel">l&ouml;schen</option>
  </select>
</div>
