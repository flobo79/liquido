<?php

error_reporting(E_ALL);

/**
 * liquidostats - Statistics.php
 *
 * $Id$
 *
 * This file is part of liquidostats.
 *
 * Automatic generated with ArgoUML 0.19.6 on 23.01.2006, 13:15:33
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */

if (0 > version_compare(PHP_VERSION, '4')) {
    die('This file was generated for PHP 4');
}

define('STATS_TABLENAME','content_stats');
define('STATS_CONTENTTABLENAME','contents');

/**
 * Short description of class Statistics
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class Statistics
{
    // --- ATTRIBUTES ---

    /**
     * Short description of attribute tablename
     *
     * @access private
     * @var string
     */
    var $_tablename = 'content_stats';

    /**
     * Short description of attribute contenttablename
     *
     * @access private
     * @var string
     */
    var $_contenttablename = 'contents';

    // --- OPERATIONS ---

    /**
     * Short description of method getContentStats
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param int
     * @param string
     * @param boolean
     * @return array
     */
    function getContentStats($pageid = 0, $timestamp = 0, $range = 'week', $childs = false)
    {
        $returnValue = array();

        // section -64--88-66-24-7f625e8e:107dcddd092:-7ffa begin
        
        // globale Objekte lokal verfuegbar machen
        //$db = $GLOBALS['db'];
        //$smarty = $GLOBALS['smarty'];
        
        // input pruefen
        $pageid = (int) $pageid;
				$timestamp = $timestamp == 0 ? time() : (int) $timestamp;
        if(!in_array($range, array('year','month','week','day')))
        {
				    trigger_error("Unknown range: ".$range, E_USER_ERROR);
				}
				$childs = (bool) $childs;
				
				// stats auslesen
				if($childs)
				{
				    $returnValue = $pageid == 0 ? Statistics::getSiteTree() : array(array('id' => $pageid, 'parent' => '', 'childs' => Statistics::getPageChilds($pageid)));
				}
				else
				{
				    $returnValue = $pageid == 0 ? Statistics::getSiteTree(false) : array(array('id' => $pageid, 'parent' => ''));
				}
				Statistics::addStatsToTree($returnValue, $timestamp, $range);
        // section -64--88-66-24-7f625e8e:107dcddd092:-7ffa end

        return (array) $returnValue;
    }

    /**
     * Short description of method getPageStats
     *
     * @access private
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param int
     * @param string
     * @return array
     */
    function _getPageStats($pageid, $timestamp, $range)
    {
        $returnValue = array();

        $from = $GLOBALS['L']->db_table(STATS_TABLENAME);
        $rangesql = "`visit_timestamp` >= %u AND `visit_timestamp` < %u GROUP BY FROM_UNIXTIME(`visit_timestamp`,'%s')";
				$returnValue['info'] = array();
				$returnValue['views'] = array();
				$returnValue['visits'] = array();
				switch($range)
				{
				    case 'year':
				        $start = mktime(0, 0, 0, 1, 1, date("Y", $timestamp));
				        $end = mktime(23, 59, 59, 12, 31, date("Y", $timestamp));
				        $groupby = "%%c.%%Y";
				        $year = date("Y", $timestamp);
				        $returnValue['views'] = array(
				            '01.'.$year => 0,
				            '02.'.$year => 0,
				            '03.'.$year => 0,
				            '04.'.$year => 0,
				            '05.'.$year => 0,
				            '06.'.$year => 0,
				            '07.'.$year => 0,
				            '08.'.$year => 0,
				            '09.'.$year => 0,
				            '10.'.$year => 0,
				            '11.'.$year => 0,
				            '12.'.$year => 0
								);
				        break;
				    case 'month':
				        $start = mktime(0, 0, 0, date("n", $timestamp), 1, date("Y", $timestamp));
				        $end = mktime(23, 59, 59, date("n", $timestamp), date("t", $timestamp), date("Y", $timestamp));
				        $groupby = "Woche %%v";
				        $ld = $start;
				        while($ld <= $end + 1)
				        {
										$weeknbr = date("W", $ld);
				            $returnValue['views']['Woche '.$weeknbr] = 0;
				            $ld += 6 * 86400;
								}
				        break;
				    case 'week':
				        $tmp = mktime(0, 0, 0, date("n", $timestamp), date("j", $timestamp), date("Y", $timestamp));
				        $dow = date("w",$timestamp) == 0 ? 6 : date("w",$timestamp) - 1;
								$start = $tmp - ($dow * 86400);
				        $end = $start + (7 * 86400) - 1;
				        $groupby = "%%w.";
				        $returnValue['views'] = array(
				            '0.' => 0,
				            '1.' => 0,
				            '2.' => 0,
				            '3.' => 0,
				            '4.' => 0,
				            '5.' => 0,
				            '6.' => 0
								);
				        break;
				    case 'day':
				        $start = mktime(0, 0, 0, date("n", $timestamp), date("j", $timestamp), date("Y", $timestamp));
				        $end = $start + 86399;
				        $groupby = "%%e.%%c.%%Y";
				        break;
				}
				$returnValue['visits'] = $returnValue['views'];
				$rangesql = sprintf($rangesql,$start,$end,$groupby);
				$sql = 'SELECT '.sprintf("FROM_UNIXTIME(visit_timestamp,'%s') AS `date`, %%s FROM `%s` WHERE `page_id` = %u AND %s",$groupby,$from,$pageid,$rangesql);
				$returnValue['info'] = array('start'=>$start, 'end'=>$end);
				$returnValue['views'] = array_merge($returnValue['views'], Statistics::_getPageViews($pageid,$sql));
				$returnValue['visits'] = array_merge($returnValue['visits'], Statistics::_getPageVisits($pageid,$sql));
        // section -64--88-66-24-7f625e8e:107dcddd092:-7fec end

        return (array) $returnValue;
    }

    /**
     * Short description of method getPageViews
     *
     * @access private
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param string
     * @return array
     */
    function _getPageViews($pageid, $rangesql)
    {
        $returnValue = array();

        // section -64--88-66-24-7f625e8e:107dcddd092:-7fe7 begin
        $sql = sprintf($rangesql,'COUNT(*) AS `views`');
        $returnValue = $GLOBALS['db']->GetAssoc($sql);
        // section -64--88-66-24-7f625e8e:107dcddd092:-7fe7 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getPageVisits
     *
     * @access private
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param string
     * @return array
     */
    function _getPageVisits($pageid, $rangesql)
    {
        $returnValue = array();

        // section -64--88-66-24-7f625e8e:107dcddd092:-7fe5 begin
        $sql = sprintf($rangesql,'COUNT(DISTINCT `visit_remote_addr`) AS `visits`');
        $returnValue = $GLOBALS['db']->GetAssoc($sql);
        // section -64--88-66-24-7f625e8e:107dcddd092:-7fe5 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getSiteTree
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param boolean
     * @return array
     */
    function getSiteTree($childs = true)
    {
        $returnValue = array();

        // section -64--88-66-123--33a7ae4:107e6065e62:-7ffc begin
        $sql = sprintf("SELECT `id`,`parent` FROM `%s` WHERE `type` = 'page' AND `del` = 0 AND `parent` = 0 ORDER BY `rank` ASC",$GLOBALS['L']->db_table(STATS_CONTENTTABLENAME));
        $returnValue = $GLOBALS['db']->GetAll($sql);
        if($childs)
        {
		        $pc = count($returnValue);
		        for($i=0;$i<$pc;$i++)
		        {
		            $returnValue[$i]['childs'] = Statistics::getPageChilds($returnValue[$i]['id']);
						}
				}
        // section -64--88-66-123--33a7ae4:107e6065e62:-7ffc end

        return (array) $returnValue;
    }

    /**
     * Short description of method getPageChilds
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @return array
     */
    function getPageChilds($pageid)
    {
        $returnValue = array();

        // section -64--88-66-123--33a7ae4:107e6065e62:-7ff9 begin
        $sql = sprintf("SELECT `id`,`parent` FROM `%s` WHERE `type` = 'page' AND `del` = 0 AND `parent` = %u ORDER BY `rank` ASC",$GLOBALS['L']->db_table(STATS_CONTENTTABLENAME),$pageid);

        $returnValue = $GLOBALS['db']->GetAll($sql);
        
        foreach($returnValue as $key => $entry) {
                $returnValue[$key]['childs'] = Statistics::getPageChilds($entry['id']);
        }
        // section -64--88-66-123--33a7ae4:107e6065e62:-7ff9 end

        return (array) $returnValue;
    }

    /**
     * Short description of method addStatsToTree
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param array
     * @param int
     * @param string
     * @return void
     */
    function addStatsToTree(&$array, $timestamp, $range)
    {
        // section -64--88-66-123--33a7ae4:107e6065e62:-7ff6 begin
				if(is_array($array))
				{
						$c=count($array);
						$k=array_keys($array);
						for($i=0; $i<$c; $i++)
						{
						    Statistics::addStatsToTree($array[$k[$i]], $timestamp, $range);
						    if(array_key_exists('id',$array))
						    {
						        $array['stats'] = Statistics::_getPageStats($array['id'], $timestamp, $range);
						    }
						}
				}
        // section -64--88-66-123--33a7ae4:107e6065e62:-7ff6 end
    }

    /**
     * Short description of method getYears
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return array
     */
    function getYears()
    {
        $returnValue = array();

        // section -64--88-66-21-22c9470b:108e8157487:-7ffc begin
        $sql = sprintf("SELECT DISTINCT FROM_UNIXTIME(`visit_timestamp`,'%%Y') AS year FROM `%s`",$GLOBALS['L']->db_table(STATS_TABLENAME));
        $returnValue = $GLOBALS['db']->GetCol($sql);
        // section -64--88-66-21-22c9470b:108e8157487:-7ffc end

        return (array) $returnValue;
    }

    /**
     * Short description of method getOverviewData
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @return array
     */
    function getOverviewData($year = 0)
    {
        $returnValue = array();

        // section -64--88-66-21-22c9470b:108e8157487:-7ffa begin
        $monate = array(
          'Januar',
          'Februar',
          'M�rz',
          'April',
          'Mai',
          'Juni',
          'Juli',
          'August',
          'September',
          'Oktober',
          'November',
          'Dezember'
    		);
        $loc_de = setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
        $y = $year > 0 ? $year : date("Y");
        $sql = sprintf("SELECT FROM_UNIXTIME(`visit_timestamp`,'%%c') AS `month`, COUNT(DISTINCT CONCAT_WS('-',`page_id`,`visit_remote_addr`)) AS `visits` FROM `%s` WHERE FROM_UNIXTIME(`visit_timestamp`,'%%Y') = %u GROUP BY FROM_UNIXTIME(`visit_timestamp`,'%%c.%%Y')",$GLOBALS['L']->db_table(STATS_TABLENAME),$y);
        $visits = $GLOBALS['db']->GetAll($sql);
        $sql = sprintf("SELECT FROM_UNIXTIME(`visit_timestamp`,'%%c') AS `month`, COUNT(*) AS `views` FROM `%s` WHERE FROM_UNIXTIME(`visit_timestamp`,'%%Y') = %u GROUP BY FROM_UNIXTIME(`visit_timestamp`,'%%c.%%Y')",$GLOBALS['L']->db_table(STATS_TABLENAME),$y);
        $views = $GLOBALS['db']->GetAll($sql);
        for($i = 0 ; $i < 12 ; $i++)
        {
        	$returnValue[$i]['month'] = $i+1;
        	//$returnValue[$i]['monthname'] = date("F",mktime(0,0,0,($i+1),1,2006));
        	$returnValue[$i]['monthname'] = $monate[$i];
        	$returnValue[$i]['visits'] = 0;
        	$returnValue[$i]['views'] = 0;
        }
        foreach($visits as $row)
        {
        	$returnValue[$row['month']-1]['visits'] = $row['visits']; 
        }
        foreach($views as $row)
        {
        	$returnValue[$row['month']-1]['views'] = $row['views']; 
        }
        //$returnValue = array_merge($returnValue,$data);
        // section -64--88-66-21-22c9470b:108e8157487:-7ffa end

        return (array) $returnValue;
    }

    /**
     * Short description of method getTopPagesByView
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param int
     * @param int
     * @return array
     */
    function getTopPagesByView($nbr = 10, $year = 0, $month = 0)
    {
        $returnValue = array();

        // section -64--88-66-21-22c9470b:108e8157487:-7ff7 begin
        $y = $year > 0 ? $year : date("Y");
        $m = $month > 0 ? $month : date("m");
        $w = $month > 0 ? "FROM_UNIXTIME(visit_timestamp,'%%Y') = ".intval($y)." AND FROM_UNIXTIME(visit_timestamp,'%%c') = ".intval($m) : "FROM_UNIXTIME(visit_timestamp,'%%Y') = ".intval($y);
        $sql = sprintf("SELECT page_id,title,FROM_UNIXTIME(visit_timestamp,'%%c') AS `month`,COUNT(*) AS `views`, COUNT(DISTINCT CONCAT_WS('-',`page_id`,`visit_remote_addr`)) AS `visits` FROM `%s` LEFT JOIN `%s` ON `page_id` = `id` WHERE ".$w." GROUP BY CONCAT_WS('-',`page_id`,FROM_UNIXTIME(`visit_timestamp`,'%%c.%%Y')) ORDER BY `views` DESC LIMIT 0,%u",$GLOBALS['L']->db_table(STATS_TABLENAME),$GLOBALS['L']->db_table(STATS_CONTENTTABLENAME),$nbr);
        $returnValue = $GLOBALS['db']->GetAll($sql);
        // section -64--88-66-21-22c9470b:108e8157487:-7ff7 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getMonthDetails
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @param int
     * @return array
     */
    function getMonthDetails($month, $year)
    {
        $returnValue = array();

        // section -64--88-66-21-22c9470b:108e8157487:-7ff4 begin
        $returnValue = Statistics::getTopPagesByView(10,$year,$month);
        // section -64--88-66-21-22c9470b:108e8157487:-7ff4 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getOverviewImg
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param int
     * @return string
     */
    function getOverviewImg($year = 0)
    {
        $returnValue = (string) '';

        // section -64--88-66-21-22c9470b:108e8157487:-7ff0 begin
		$jahr = $year > 0 ? intval($year) : intval(date("Y"));
		$file = str_replace('\\','/',dirname(__FILE__));
		$datadir = substr($file,0,strrpos($file,'/')).'/data/';
        $usecached = $jahr < intval(date("Y")) ? true : false;
        $imgfile = $jahr.'.png';
        
		if(!$usecached || !file_exists($datadir.$imgfile))
		{
			$phpv=explode(".",phpversion());
			$phpv=$phpv[0];
			
			define("ANTIALIAS",false);
			
			require_once("jpgraph-php".$phpv."/jpgraph.php");
			require_once("jpgraph-php".$phpv."/jpgraph_bar.php");
			
			$data = Statistics::getOverviewData($jahr);
			
			$datay_views=array();
			$datay_visits=array();
			
			for($i=1;$i<=12;$i++) {
			  $datay_visits[$i-1]=$data[$i-1]['visits'];
			  $datay_views[$i-1]=$data[$i-1]['views'];
			}
			
			$graph = new Graph(500,200,'auto');	
			$graph->img->SetMargin(40,20,40,70);
			$graph->SetScale("textint");
			$graph->SetFrame(true,'#B7B7B7',1); 
			$graph->SetColor('#F8F8F8');
			$graph->SetMarginColor('#F8F8F8');
			
			$graph->legend->SetLayout(LEGEND_HOR);
			$graph->legend->Pos(0.5,0.96,"center","bottom");
			
			$graph->legend->SetShadow('#B7B7B7@0.5');
			$graph->legend->SetFillColor('white@0.3');
			
			$graph->yaxis->scale->SetGrace(10);
			
			$gDateLocale->Set('german');
			$a = $gDateLocale->GetShortMonth();
			$graph->xaxis->SetTickLabels($a);
			$graph->xaxis->SetFont(FF_FONT1);
			$graph->xaxis->SetColor('black','black');
			
			$graph->yaxis->SetColor('#F8F8F8','black');
			$graph->ygrid->SetColor('#B7B7B7');
			
			$graph->title->Set('Besucherstatistik');
			$graph->subtitle->Set('Jahr '.$jahr);
			
			$bplot1 = new BarPlot($datay_visits);
			$bplot2 = new BarPlot($datay_views);
			
			$bplot1->SetFillColor('#CCCCCC@0.4');
			$bplot2->SetFillColor('#666666@0.4');
			
			$bplot1->SetLegend('Visits');
			$bplot2->SetLegend('Views');
			
			// Zahlen ueber Balken
			$bplot1->value->Show();
			if(ANTIALIAS) {
			  $bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,8);
			} else {
			  $bplot1->value->SetFont(FF_FONT0);
			}
			$bplot1->value->SetFormat('%d');
			$bplot1->value->SetColor("black","darkred");
			$bplot2->value->Show();
			if(ANTIALIAS) {
			  $bplot2->value->SetFont(FF_ARIAL,FS_NORMAL,8);
			} else {
			  $bplot2->value->SetFont(FF_FONT0);
			}
			$bplot2->value->SetFormat('%d');
			$bplot2->value->SetColor("black","darkred");
			
			$gbarplot = new GroupBarPlot(array($bplot1,$bplot2));
			$gbarplot->SetWidth(0.8);
			$graph->Add($gbarplot);
			
			$graph->Stroke($datadir.$imgfile);
		}
		$returnValue = $imgfile;
        // section -64--88-66-21-22c9470b:108e8157487:-7ff0 end

        return (string) $returnValue;
    }

} /* end of class Statistics */

?>
