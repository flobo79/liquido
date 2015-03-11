<?php

error_reporting(E_ALL);

/**
 * bouncechecker - Filter.php
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

/**
 * include Filterregel
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
require_once('Filterregel.php');

/* user defined includes */
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff9-includes begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff9-includes end

/* user defined constants */
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff9-constants begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7ff9-constants end

/**
 * Short description of class Filter
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class Filter
{
    // --- ATTRIBUTES ---

    /**
     * Short description of attribute filterID
     *
     * @access public
     * @var int
     */
    var $filterID = 0;

    /**
     * Short description of attribute name
     *
     * @access public
     * @var string
     */
    var $name = '';

    /**
     * Short description of attribute priority
     *
     * @access public
     * @var int
     */
    var $priority = 0;

    /**
     * Short description of attribute rules
     *
     * @access public
     * @var array
     */
    var $rules = array();

    /**
     * "one" - es reicht wenn eine Regel zutrifft
     * "all" - alle Regeln muessen zutreffen
     *
     * @access public
     * @var string
     */
    var $type = '';

    // --- OPERATIONS ---

    /**
     * Short description of method Filter
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param string
     * @param int
     * @param string
     * @return void
     */
    function Filter($id, $name, $prio, $type)
    {
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fe0 begin
        $this->filterID=(int )$id;
        $this->name=$name;
        $this->priority=(int) $prio;
        $this->type=$type;
        $this->loadRules();
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fe0 end
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

        // section -64--88-0-105--65df3e3e:105abc6decf:-7fd5 begin
        foreach($this->rules as $rule)
        {
				    $ok = $rule->execute($email);
						if(!$ok && $this->type=='all')
				    {
						    return false;
						} elseif($ok && $this->type=='one')
						{
					      return true;
						}
				}
				$returnValue = $ok;
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fd5 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method loadRules
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return boolean
     */
    function loadRules()
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fd4 begin
        $db =& $GLOBALS['db'];
				$sql=sprintf("SELECT r.ruleID,r.what,r.casesensitive,w.field,o.function FROM %sfilterrules r JOIN %swhere w USING(whereID) JOIN %soperations o ON r.operationID=o.operationID WHERE r.active = 1 AND r.filterID = %u ORDER BY priority ASC",PREFIX,PREFIX,PREFIX,$this->filterID);
				$rs =& $db->execute($sql);
				while (!$rs->EOF)
				{
				    $r = new Filterregel($rs->fields['ruleID'],$rs->fields['function'],$rs->fields['field'],$rs->fields['what'],$rs->fields['casesensitive']);
				    $this->rules[] = $r;
						$rs->MoveNext();
				}
				$returnValue = true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fd4 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method getName
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return string
     */
    function getName()
    {
        $returnValue = (string) '';

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fc3 begin
        $returnValue = $this->name;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fc3 end

        return (string) $returnValue;
    }

    /**
     * Short description of method getID
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return int
     */
    function getID()
    {
        $returnValue = (int) 0;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fb8 begin
        $returnValue = $this->filterID;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fb8 end

        return (int) $returnValue;
    }

} /* end of class Filter */

?>