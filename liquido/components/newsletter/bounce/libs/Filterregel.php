<?php

error_reporting(E_ALL);

/**
 * bouncechecker - Filterregel.php
 *
 * $Id$
 *
 * This file is part of bouncechecker.
 *
 * Automatic generated with ArgoUML 0.19.3 on 29.08.2005, 10:11:23
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */

if (0 > version_compare(PHP_VERSION, '4')) {
    die('This file was generated for PHP 4');
}

/* user defined includes */
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff7-includes begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff7-includes end

/* user defined constants */
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff7-constants begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff7-constants end

/**
 * Short description of class Filterregel
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class Filterregel
{
    // --- ATTRIBUTES ---

    /**
     * Short description of attribute regelID
     *
     * @access public
     * @var int
     */
    var $regelID = 0;

    /**
     * Short description of attribute function
     *
     * @access public
     * @var string
     */
    var $function = '';

    /**
     * Short description of attribute field
     *
     * @access public
     * @var string
     */
    var $field = '';

    /**
     * Short description of attribute search
     *
     * @access public
     * @var string
     */
    var $search = '';

    /**
     * Short description of attribute casesensitiv
     *
     * @access public
     * @var boolean
     */
    var $casesensitiv = false;

    // --- OPERATIONS ---

    /**
     * Short description of method Filterregel
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param string
     * @param string
     * @param string
     * @param boolean
     * @return void
     */
    function Filterregel($id, $function, $field, $search, $casesensitiv)
    {
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fdd begin
        $this->regelID = (int) $id;
        $this->function = create_function('$text,$search',$function);
        $this->field = $field;
        $this->casesensitiv = (bool) $casesensitiv;
        $this->search = $this->casesensitiv ? $search : strtolower($search);
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fdd end
    }

    /**
     * Short description of method execute
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param Email
     * @return boolean
     */
    function execute($email)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fda begin
        $arr = explode('>',$this->field);
        $target=$email;
				$i=0;
				foreach($arr as $a)
				{
				    if($i++==0)
				    {
						    $target=$target->$a;
						}
				    else
				    {
						    if(array_key_exists($a,$target) == false)
						    {
								    return false;
								}
								$target=$target[$a];
						}
				}
				ob_start();
				print_r($target);
        $text = ob_get_contents();
        ob_end_clean();
				$text = $this->casesensitiv ? $text : strtolower($text);
				$f=$this->function;
        $returnValue = $f($text,$this->search);
        //echo "----> $text ----> ".$this->search." = $returnValue<hr>\n";
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fda end

        return (bool) $returnValue;
    }

} /* end of class Filterregel */

?>