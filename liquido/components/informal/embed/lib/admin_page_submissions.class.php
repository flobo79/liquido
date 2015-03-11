<?php

class admin_page_submissions extends admin_page
{
    var $headline = 'Admin';
    var $name = 'submissions';
    
    function create_content_array() {
        $informal = new informal($GLOBALS['informal_form_id']);

        $submissions = $informal->get_submissions_from_db($informal->id);

        // pack submissions into array
        foreach ($submissions as $f => $s) {
            $submissions[$f]['values'] = wddx_deserialize($s['data']);
        }
		debug($informal);
		

		// schnell und schmutzig
		global $smarty;
		$smarty -> assign("submissions",$submissions);		
		
        return $submissions;
    }
}

?>
