<?php
echo urldecode($_GET['email']);
//$mpquery = "SELECT mp FROM vwc_liquido_nl_abos WHERE email='".$_GET['email']."' AND id='".$_GET['aboid']."' LIMIT 1";
$mpquery = "SELECT mp FROM vwc_liquido_nl_abos WHERE email='m.reisch@missionmedia.de' AND id='8830' LIMIT 1";
$bereiche = db_array($mpquery); 

foreach ($bereiche as $bereich)
{
	$userareas = explode(";",$bereich['mp']);
}

$areaquery = "SELECT id,title FROM vwc_liquido_nl_areas";
$areanames = db_array($areaquery); 

if ($_POST['submit'])
{	
        $set = $_POST['set'];
		$email = $_POST['update']['email'];
		$aboid = $_POST['update']['aboid'];
		
		// erstelle separierten String zur Speicherung in DB                                                                          
        $mp = ";".implode(";", $set).";";                                                                                                                    
                                                                                                                                      
        // wenn von aktuellem updateform kommt, ist eine ID enthalten, welche dazu dient, einen Eintrag zu identifizieren             
        if(intval($aboid)) $and = " and id = '".intval($aboid)."' "; else die("Die Abonnenten-ID ist ung&uuml;ltig");
        
        // puefe email Syntax                                                                                                         
        if(!preg_match("/^[A-Za-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$/", $email)) die("Die angegebene Email-Adresse kann nicht verwendet werden");
                                                                                                                                      
        // wenn alles ok ist erzeuge dbstring und los gehts                                                                           
        $sql = "update vwc_liquido_nl_abos set 'mp' = '".$mp."' where 'email' = '".mysql_escape_string($email)."' ".$and." LIMIT 1";          
        echo $sql;
        //$result = db_query($sql);                                                                                                            
                                                                                                                                  
        echo "Die Einstellungen wurden gespeichert";
}
else
{

$objecttitle = "Bereichs-Auswahl aktualisieren";

$s = 1;
if(isset($this->publishing)) {
	$this->s[] = $i;
}

if(!$object) {
	if($part == "compose") {
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
		$disabled = "disabled";
	}
	?>
      <input name="objectdata[<? echo $result['id']; ?>][type]" type="hidden" value="<?php echo $result['type']; ?>"> 
      <input name="objectdata[<? echo $result['id']; ?>][layout]" type="hidden" value="<?php echo $result['layout']; ?>">
<?php }
global $ispublishing;
global $thiscomp;

?>
<?php if($part != "compose") { ?><form name="form1" method="post" action="#"><?php } ?>
  Ihre E-Mail-Adresse: <br>
  <input name="update[email]" type="text" id="email" value="<?php echo $_GET['email'] ?>" class="feld" <?php if($part == "compose") echo "disabled"; ?> ><br />
  Ihre Abonnenten-ID: <?php echo $_GET['aboid'] ?><br>
  <input name="update[aboid]" type="text" id="aboid" value="<?php echo $_GET['aboid'] ?>" class="feld" <?php if($part == "compose") echo "disabled"; ?> ><br />

  <?php
	foreach($areanames as $areaname) {
		if($part != "compose" ) {
			
			$checked = "";
			foreach($userareas as $userarea)
			{
				if($checked == "") $checked = ($userarea == $areaname['id']) ? 'checked' : '';
			}
			
		}
		echo "<input type='checkbox' name='set[".$z."]' value='".$areaname['id']."' ".$checked." ".$disabled."> ".$areaname['title']."<br />\n";
		$z++;
	}
	?>
<input type="submit" style="margin-left: 18px; margin-top: 5px;" name="submit" value="speichern" class="button" <?php if($part == "compose") echo "disabled"; ?>><br />

<?php if($part != "compose") { ?></form><?php } }?>