<?php

error_reporting(E_ALL);

/**
 * bouncechecker - Email.php
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
// section -64--88-0-105--65df3e3e:105abc6decf:-7ffb-includes begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7ffb-includes end

/* user defined constants */
// section -64--88-0-105--65df3e3e:105abc6decf:-7ffb-constants begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7ffb-constants end

/**
 * Short description of class Email
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class Email
{
    // --- ATTRIBUTES ---

    /**
     * Short description of attribute fromEmail
     *
     * @access public
     * @var string
     */
    var $fromEmail = '';

    /**
     * Short description of attribute fromName
     *
     * @access public
     * @var string
     */
    var $fromName = '';

    /**
     * Short description of attribute date
     *
     * @access public
     * @var string
     */
    var $date = '';

    /**
     * Short description of attribute header
     *
     * @access public
     * @var array
     */
    var $header = array();

    /**
     * Short description of attribute body
     *
     * @access public
     * @var array
     */
    var $body = array();

    /**
     * Short description of attribute source
     *
     * @access public
     * @var string
     */
    var $source = '';

    // --- OPERATIONS ---

    /**
     * Short description of method Email
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */
    function Email()
    {
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fed begin
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fed end
    }

    /**
     * Short description of method setHeader
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param array
     * @return boolean
     */
    function setHeader($header)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe9 begin
        $this->header=$header;
        $this->date=$header['date'];
        $returnValue=true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe9 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setBody
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param array
     * @return boolean
     */
    function setBody($body)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe6 begin
        $this->body=$body;
        $returnValue=true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe6 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setFromEmail
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return boolean
     */
    function setFromEmail($email)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe3 begin
        $this->fromEmail=$email;
        $returnValue=true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe3 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setFromName
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return boolean
     */
    function setFromName($name)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe0 begin
        $this->fromName=$name;
        $returnValue=true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fe0 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setSource
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return void
     */
    function setSource($src)
    {
        // section -64--88-66-24-6df7d064:106013cad8f:-7ff2 begin
        $this->source=$src;
        // section -64--88-66-24-6df7d064:106013cad8f:-7ff2 end
    }

} /* end of class Email */

?>