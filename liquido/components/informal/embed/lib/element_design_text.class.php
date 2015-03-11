<?php

class element_design_text extends element
{
	var $collects_input = false;
	var $name = 'design_text';
	var $title = 'Textabsatz';
	var $toggle_mandatory = false;
	var $toggle_visibility = false;

	function element_design_text()
	{
		$this->add_collector('text','textarea','Text (kann HMTL beinhalten)',
			array('cols' => '60','rows' => '6'), '', '', '', true);
	}

}

?>
