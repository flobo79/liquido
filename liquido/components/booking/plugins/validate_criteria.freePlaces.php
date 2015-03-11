<?php

function smarty_validate_criteria_freePlaces($value, $empty, &$params, &$formvars) {
    if(!isset($params['field2'])) {
            trigger_error("SmartyValidate: [freePlaces] parameter 'date_id' is missing.");            
            return false;
    } else {
    	if(strpos($params['field2'],"[") > 0) {
    		preg_match("#(\S*)\[(\d*)\]#", $params['field2'], $treffer);
    		$_date_id=intval($formvars[$treffer[1]][$treffer[2]]);
    	} else {
    		$_date_id=intval($formvars[$params['field2']]);
    	}
    }
    
    if(!isset($params['field3'])) {
            trigger_error("SmartyValidate: [freePlaces] parameter 'rs_id' is missing.");            
            return false;
    } else {
    	if(strpos($params['field3'],"[") > 0) {
    		preg_match("#(\S*)\[(\d*)\]#", $params['field3'], $treffer);
    		$_rs_id=intval($formvars[$treffer[1]][$treffer[2]]);
    	} else {
    		$_rs_id=intval($formvars[$params['field3']]);
    	}
    }
    
    $places=intval($value);
    
    if($places == 0)
        return $empty;
        
	global $booking;
	if(!$booking->sql->DB) {
		return false;
	} else {
		//echo "<pre>"; print_r($formvars); echo "</pre>";
		$sql="SELECT st_capacity_act FROM ".PREFIX."dates WHERE date_id = '".$_date_id."'";
		$frei=$booking->sql->DB->GetOne($sql);
		//echo "$sql ::: $frei<br>";
		$sql="SELECT rs_places FROM ".PREFIX."reserv WHERE rs_id = '".$_rs_id."'";
		$old=$booking->sql->DB->GetOne($sql);
		//echo "$sql ::: $old";
		if(($frei+$old) >= $places) {
			return true;
		} else {
		    return false;
		}
	}
}

?>
