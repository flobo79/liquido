<?
require_once("config.inc.php");
$DB = ADONewConnection(DBTYPE);
$DB->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$DB) die("Systemfehler!");
$DB->SetFetchMode(ADODB_FETCH_ASSOC);
$sql="SELECT DISTINCT DATE_FORMAT(rs_date,'%M %Y') AS filter, DATE_FORMAT(rs_date,'%m') AS monat,DATE_FORMAT(rs_date,'%Y') AS jahr FROM ".PREFIX."reserv ORDER BY rs_date DESC";
$options=$DB->GetAll($sql);
/*
echo $sql;
echo "<!--\n";
print_r($options);
echo "-->\n";
*/
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
			<option	value="<? echo $datum['jahr']."-".$datum['monat']; ?>"<? if(date("Y-m")==$datum['jahr']."-".$datum['monat']) echo " selected"; ?>><? echo $month_names_de[intval($datum['monat'])-1]." ".$datum['jahr']; ?></option>
<?
}
?>
		</select>
  <input type="button" name="Button" value="ok" onclick="showduration()">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <select name="selection" onchange="showselection(this.options[this.selectedIndex].value);">
    <option selected>zeige ...</option>
	<option value="">alle</option>
    <option value="notconfirmed">nicht best&auml;tigt</option>
    <option value="notsent">Rechnung nicht versendet</option>
    <option value="notpayed">Rechnung nicht bezahlt</option>
    <option value="notparticipantinfossend">Tickets nicht versandt</option>
    <option value="notannounceconfirmsend">Buchungsbest�tigung nicht versandt</option>
    <option value="notannounceconfirmrecv">Buchungsbest�tigung nicht erhalten</option>
    <option value="coupons">Gutschein verwendet</option>
  </select>
	
	<select name="aktion" onchange="doaction(this.options[this.selectedIndex].value,this);">
    <option selected>Aktionen ...</option>
    <option value="multiconfirm">best&auml;tigen</option>
    <option value="multiedit">bearbeiten</option>
    <option value="multidel">l&ouml;schen</option>
    <option>-------------------</option>
    <option value="multimarkassent">Rechnung versandt</option>
    <option value="multimarkasnotsent">Rechnung nicht versandt</option>
    <option value="multimarkaspayed">Rechnung bezahlt</option>
    <option value="multimarkasnotpayed">Rechnung nicht bezahlt</option>
    <option>-------------------</option>
    <option value="multimarkparticipantinfossend">Tickets versandt</option>
    <option value="multimarkparticipantinfosnotsend">Tickets nicht versandt</option>
    <option value="multimarkannounceconfirmsend">Buchungsbest�tigung versandt</option>
    <option value="multimarkannounceconfirmnotsend">Buchungsbest�tigung nicht versandt</option>
    <option value="multimarkannounceconfirmrecv">Buchungsbest�tigung erhalten</option>
    <option value="multimarkannounceconfirmnotrecv">Buchungsbest�tigung nicht erhalten</option>
  </select>
</div>
