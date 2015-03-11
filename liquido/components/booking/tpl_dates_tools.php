<?
require_once("config.inc.php");
$DB = ADONewConnection(DBTYPE);
$DB->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$DB) die("Systemfehler!");
$DB->SetFetchMode(ADODB_FETCH_ASSOC);
$sql="SELECT DISTINCT DATE_FORMAT(dt_date,'%M %Y') AS filter, DATE_FORMAT(dt_date,'%m') AS monat,DATE_FORMAT(dt_date,'%Y') AS jahr FROM ".PREFIX."dates ORDER BY dt_date DESC";
$options=$DB->GetAll($sql);
echo "<!--\n";
print_r($options);
echo "-->\n";
$DB->Close();
$month_names_de  = array("Januar","Feburar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
?>
<div id="booking_tools">
		Zeitraum: <select name="from" id="from">
<?
foreach($options as $datum) {
?>
			<option	value="<? echo $datum['jahr']."-".$datum['monat']; ?>"<? if(date("Y-m",strtotime("-1 month"))==$datum['jahr']."-".$datum['monat']) echo " selected"; ?>><? echo $month_names_de[intval($datum['monat'])-1]." ".$datum['jahr']; ?></option>
<?
}
?>
		</select>
		bis:
		<select name="to" id="to">
<?
foreach($options as $datum) {
?>
			<option	value="<? echo $datum['jahr']."-".$datum['monat']; ?>"><? echo $month_names_de[intval($datum['monat'])-1]." ".$datum['jahr']; ?></option>
<?
}
?>
		</select>
  <input type="button" name="Button" value="ok" onclick="showduration()">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <select name="from"  onchange="doaction(this.options[this.selectedIndex].value,this);">
    <option selected>Aktionen ...</option>
    <option value="multisetfree">freigeben</option>
    <option value="multiblock">zur&uuml;ckziehen</option>
    <option value="multisetfullreservation">ausgebucht</option>
    <option value="multisetnotfullreservation">nicht ausgebucht</option>
	<option>------------------</option>
    <option value="multiedit">bearbeiten</option>
    <option value="multidel">l&ouml;schen</option>
  </select>
</div>
