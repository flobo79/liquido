<?php

error_reporting(E_ALL);

/**
 * bouncechecker - EmailParser.php
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

/**
 * include Filter
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
require_once('Filter.php');

/**
 * include MIMEDECODE
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
require_once('MIMEDECODE.php');

/**
 * include Ruecklaeufer
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
require_once('Ruecklaeufer.php');

/**
 * Short description of class EmailParser
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class EmailParser
    extends MIMEDECODE
{
    // --- ATTRIBUTES ---

    /**
     * Short description of attribute filters
     *
     * @access public
     * @var array
     */
    var $filters = array();

    // --- OPERATIONS ---

    /**
     * Short description of method EmailParser
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */
    function EmailParser()
    {
        // section -64--88-0-105--65df3e3e:105abc6decf:-7ff0 begin
        $this->loadFilters();
        // section -64--88-0-105--65df3e3e:105abc6decf:-7ff0 end
    }

    /**
     * Short description of method parseEmail
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return Email
     */
    function parseEmail($emailsource)
    {
        $returnValue = null;

        // section -64--88-0-105--65df3e3e:105abc6decf:-7feb begin
        parent::MIMEDECODE($emailsource,"\r\n");
        $msg = $this->decode();
        // Header nochmals decodieren
        foreach($msg->headers as $key=>$line)
        {
            $msg->headers[$key] = $this->decodeMime($line);
				}
        //print_r($msg);
        $returnValue = new Ruecklaeufer($emailsource);
        $from = $this->parseFromString($msg->headers['from']);
        $returnValue->setFromEmail($from['email']);
        $returnValue->setFromName($from['name']);
        $bodies=array();
        if(isset($msg->parts))
        {
				    foreach($msg->parts as $part)
            {
				        if(isset($part->body))
				        {
		                $bodies[]=$part->body;
                }
				        if(isset($part->parts))
				        {
								    foreach($part->parts as $subpart)
				            {
								        if(isset($subpart->body))
								        {
						                $bodies[]=$subpart->body;
				                }
								    }
								}
				    }
				}
				else
				{
				    $bodies[]=$msg->body;
				}
        $returnValue->setBody($bodies);
        $returnValue->setHeader($msg->headers);
        // section -64--88-0-105--65df3e3e:105abc6decf:-7feb end

        return $returnValue;
    }

    /**
     * Short description of method parseFromString
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return array
     */
    function parseFromString($from)
    {
        $returnValue = array();

        // section -64--88-0-105--65df3e3e:105abc6decf:-7fe8 begin
        preg_match('/((?:(?:(?:[a-zA-Z0-9][\.\-\+_]?)*)[a-zA-Z0-9])+)\@((?:(?:(?:[a-zA-Z0-9][\.\-_]?){0,62})[a-zA-Z0-9])+)\.([a-zA-Z0-9]{2,6})/',$from,$matches);
        $returnValue['email']= count($matches) > 0 ? $matches[0] : 'no email found';
        $filter=array($returnValue['email'],'"',"'",'<','>','(',')');
				$returnValue['name']=trim(str_replace($filter,'',$from));
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fe8 end

        return (array) $returnValue;
    }

    /**
     * Short description of method loadFilters
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return boolean
     */
    function loadFilters()
    {
        $returnValue = (bool) false;

        // section -64--88-0-105--65df3e3e:105abc6decf:-7fc7 begin
        //$db =& $GLOBALS['db'];
		global $db;
		
		$sql=sprintf("SELECT * FROM %sfilters WHERE active = 1 ORDER BY priority ASC, name ASC",PREFIX);
		$rs =& $db->execute($sql);
		while (!$rs->EOF)
		{
		    $f = new Filter($rs->fields['filterID'],$rs->fields['name'],$rs->fields['priority'],$rs->fields['type']);
		    $this->filters[intval($rs->fields['filterID'])] = $f;
				$rs->MoveNext();
		}
		$returnValue = true;
        // section -64--88-0-105--65df3e3e:105abc6decf:-7fc7 end

        return (bool) $returnValue;
    }

    /**
     * Short description of method getMatchingFilters
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param Email
     * @return array
     */
    function getMatchingFilters($email)
    {
        $returnValue = array();

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fc8 begin
        foreach($this->filters as $filter)
        {
            if($filter->execute($email))
            {
						    $returnValue['ids'][]=$filter->getID();
						    $returnValue['namen'][]=$filter->getName();
						}
				}
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fc8 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getFilternameByID
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @return string
     */
    function getFilternameByID($filterID)
    {
        $returnValue = (string) '';

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fa8 begin
        if(array_key_exists($filterID,$this->filters))
        {
            $returnValue = $this->filters[$filterID]->getName();
				}
				else
				{
				    $db =& $GLOBALS['bouncedb'];
				    $sql=sprintf("SELECT name FROM %sfilters WHERE filterID = %u",PREFIX,$filterID);
				    $returnValue = $db->GetOne($sql);
				}
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fa8 end

        return (string) $returnValue;
    }

    /**
     * Short description of method decodeMime
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @return string
     */
    function decodeMime($text)
    {
        $returnValue = (string) '';

        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fa5 begin
        // Header nochmals decodieren
        if(!is_string($text))
        {
				    return false;
				}
				else
				{
				    $elements=imap_mime_header_decode($text);
				    foreach($elements as $parts)
				    {
				        $returnValue.=$parts->text;
						}
				}
        // section -64--88-0-105--7922c1b8:105ba0c8ac6:-7fa5 end

        return (string) $returnValue;
    }

} /* end of class EmailParser */

?>