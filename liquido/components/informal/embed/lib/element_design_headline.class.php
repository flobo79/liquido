<?php

class element_design_headline extends element
{
	var $collects_input = false;
	var $name = 'design_headline';
	var $title = 'Überschrift';
	var $toggle_mandatory = false;
	var $toggle_visibility = false;

	function element_design_headline()
	{
		$this->add_collector('text','text','Text',
			array('size' => '60'), '', '', '', true);
	}

}

?>
