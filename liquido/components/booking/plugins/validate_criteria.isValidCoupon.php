<?php

function smarty_validate_criteria_isValidCoupon($value, $empty, &$params, &$formvars) {

	$_SESSION['invalidcoupon']="";

    $coupons=explode(",",str_replace(" ","",$value));
    //$coupons_where=implode("' AND cp_nr = '",$coupons);
    $coupons_insert=implode("'),('",$coupons);
    
    if(!$value)
        return $empty;
        
	global $booking;
	if(!$booking->sql->DB) {
		return false;
	} else {
		//echo "<pre>"; print_r($formvars); echo "</pre>";
		//$sql="CREATE TEMPORARY TABLE coupons SELECT cp_nr FROM ".PREFIX."coupons WHERE cp_nr = '".$coupons_where."'";
		$sql="CREATE TEMPORARY TABLE IF NOT EXISTS ".PREFIX."tmpcoupons (cp_nr_tmp VARCHAR(255))";
		$ok=$booking->sql->DB->Execute($sql);
		$sql="INSERT INTO ".PREFIX."tmpcoupons VALUES ('".$coupons_insert."')";
		$ok=$booking->sql->DB->Execute($sql);
		$sql="SELECT cp_nr_tmp FROM ".PREFIX."tmpcoupons t LEFT JOIN ".PREFIX."coupons c ON t.cp_nr_tmp=c.cp_nr WHERE c.cp_nr IS NULL";
		//$sql="SELECT * FROM ".PREFIX."tmpcoupons";
		$error=$booking->sql->DB->GetCol($sql);
		//print_r($error);
		if(count($error)==0) {
			$_SESSION['invalidcoupon']="";
			return true;
		} else {
			$_SESSION['invalidcoupon']=implode(", ",$error);
			return false;
		}
	}
}

?>
