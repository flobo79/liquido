<?
require_once('js/jscalendar/calendar.php');
$cal = new DHTML_Calendar('/liquido/modules/content_stats/js/jscalendar/','de','calendar-blue');
$cal->load_files();
$cal->set_option('flat','statscalendar');
$cal->set_option('firstDay',1);
$cal->set_option('flatCallback','dateChanged');
//print_r($cal);
//echo $cal->_make_calendar();
?>
