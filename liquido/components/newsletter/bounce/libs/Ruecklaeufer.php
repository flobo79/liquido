<?php

error_reporting(E_ALL);

/**
 * bouncechecker - Ruecklaeufer.php
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
 * include Email
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
require_once('Email.php');

/* user defined includes */
// section -64--88-0-105--65df3e3e:105abc6decf:-7fdb-includes begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7fdb-includes end

/* user defined constants */
// section -64--88-0-105--65df3e3e:105abc6decf:-7fdb-constants begin
// section -64--88-0-105--65df3e3e:105abc6decf:-7fdb-constants end

/**
 * Short description of class Ruecklaeufer
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class Ruecklaeufer
    extends Email
{
    // --- ATTRIBUTES ---

    /**
     * Short description of attribute isSubscribed
     *
     * @access public
     * @var boolean
     */
    var $isSubscribed = false;

    /**
     * Short description of attribute subscriberID
     *
     * @access public
     * @var int
     */
    var $subscriberID = 0;

    /**
     * Short description of attribute newsletterID
     *
     * @access public
     * @var int
     */
    var $newsletterID = 0;

    /**
     * Short description of attribute filterIDs
     *
     * @access public
     * @var array
     */
    var $filterIDs = array();

    /**
     * Short description of attribute toEmail
     *
     * @access public
     * @var string
     */
    var $toEmail = '';

    /**
     * Short description of attribute emailID
     *
     * @access public
     * @var int
     */
    var $emailID = 0;

    // --- OPERATIONS ---

    /**
     * Short description of method Ruecklaeufer
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return void
     */
    function Ruecklaeufer($src)
    {
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fd7 begin
        $this->setSource($src);
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fd7 end
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

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fdd begin
        parent::setHeader($header);
        $this->isSubscribed=$this->checkSubscription();
        $this->setNewsletterID();
        $returnValue = true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fdd end

        return (bool) $returnValue;
    }

    /**
     * Short description of method checkSubscription
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return boolean
     */
    function checkSubscription()
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fbf begin
        $db =& $GLOBALS['db'];
        if(preg_match('/Subscriber-ID: (\d*)/i',$this->source,$matches))
        {
            $sql = sprintf("SELECT email FROM fs_liquido_nl_abos WHERE id = %u",$matches[1]);
            $to = $db->GetOne($sql);
            $this->toEmail = $to;
            $this->subscriberID = $matches[1];
            $returnValue = $to ? true : false;
        }
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fbf end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setNewsletterID
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return boolean
     */
    function setNewsletterID()
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fbd begin
        if(preg_match('/Liquido-Newsletter-ID: (\d*)/i',$this->source,$matches))
        {
            $this->newsletterID = (int) $matches[1];
				}
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fbd end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setFilterIDs
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param array
     * @param boolean
     * @return boolean
     */
    function setFilterIDs($filterIDs, $saveToDB = false)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fbb begin
        $this->filterIDs = (array) $filterIDs;
        if($saveToDB)
        {
            $this->saveToDB();
        }
        $returnValue = true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fbb end

        return (bool) $returnValue;
    }

    /**
     * Short description of method saveToDB
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return boolean
     */
    function saveToDB()
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fb5 begin
        $db =& $GLOBALS['db'];
        $fids = $this->filterIDs ? "'".mysql_escape_string(implode(',',$this->filterIDs))."'" : 'NULL';
        $nid = $this->newsletterID == 0 ? 'NULL' : intval($this->newsletterID);
        $sid = $this->subscriberID == 0 ? 'NULL' : intval($this->subscriberID);
        $sql = sprintf("UPDATE %semails SET filterIDs = %s, newsletterID = %s, subscriberID = %s WHERE id = %u",PREFIX,$fids,$nid,$sid,$this->emailID);
        //echo $sql;
        $returnValue = $db->Execute($sql);
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fb5 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method getFilterIDs
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return array
     */
    function getFilterIDs()
    {
        $returnValue = array();

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fb3 begin
        $returnValue = $this->filterIDs;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fb3 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getToEmail
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return string
     */
    function getToEmail()
    {
        $returnValue = (string) '';

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fae begin
        $returnValue = $this->toEmail;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fae end

        return (string) $returnValue;
    }

    /**
     * Short description of method setEmailID
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @return boolean
     */
    function setEmailID($id)
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fab begin
        $this->emailID = (int) $id;
        $returnValue = true;
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fab end

        return (bool) $returnValue;
    }

    /**
     * Short description of method setSubscriberID
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @return void
     */
    function setSubscriberID($id)
    {
        // section -64--88-66-24-6df7d064:106013cad8f:-7ff6 begin
        $this->subscriberID = (int) $id;
        // section -64--88-66-24-6df7d064:106013cad8f:-7ff6 end
    }

} /* end of class Ruecklaeufer */

?>