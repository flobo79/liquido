<?php
require_once('libs/Statistics.php');
require_once('jscalendar.inc.php');

if(!array_key_exists('contentstat',$_SESSION)) $_SESSION['contentstat'] = array();
if(isset($_POST['range'])) $_SESSION['contentstat']['range'] = $_POST['range'];
if(isset($_POST['timestamp']) && $_POST['timestamp'] > 0) $_SESSION['contentstat']['timestamp'] = intval($_POST['timestamp']);
if(!array_key_exists('range',$_SESSION['contentstat'])) $_SESSION['contentstat']['range'] = 'week';
if(!array_key_exists('timestamp',$_SESSION['contentstat'])) $_SESSION['contentstat']['timestamp'] = time();

$page_stats = Statistics::getContentStats($data['id'],$_SESSION['contentstat']['timestamp'],$_SESSION['contentstat']['range'],false);

$smarty->assign('range',$_SESSION['contentstat']['range']);
$smarty->assign('jscal',$cal->_make_calendar());
$smarty->assign('parsedate',date("F d, Y H:i:s",$_SESSION['contentstat']['timestamp']));
$smarty->assign('timestamp',$_SESSION['contentstat']['timestamp']);

$label = '';
$output = array();
if(isset($page_stats[0]['stats']))
switch($_SESSION['contentstat']['range'])
{
  case 'week':
    $label = 'Woche vom '.date('d.m.',$page_stats[0]['stats']['info']['start']).' bis '.date('d.m.Y',$page_stats[0]['stats']['info']['end']);
    $labels = array(
      '0.' => 'Sonntag',
      '1.' => 'Montag',
      '2.' => 'Dienstag',
      '3.' => 'Mittwoch',
      '4.' => 'Donnerstag',
      '5.' => 'Freitag',
      '6.' => 'Samstag'
		);
    $keys = array_keys($page_stats[0]['stats']['views']);
    $so = array();
    foreach($keys as $key)
    {
        if($key != '0.')
        {
					$output[]=array(
					  'text' => $labels[$key],
						'views' => $page_stats[0]['stats']['views'][$key],
						'visits' => $page_stats[0]['stats']['visits'][$key]
					);
				}
				else
				{
				  $so=array(
					  'text' => $labels[$key],
						'views' => $page_stats[0]['stats']['views'][$key],
						'visits' => $page_stats[0]['stats']['visits'][$key]
					);
				}
		}
		$output[]=$so;
    break;
  case 'month':
		$loc_de = setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
    $label = 'Monat '.strftime('%B %Y',$page_stats[0]['stats']['info']['start']);
    $keys = array_keys($page_stats[0]['stats']['views']);
    foreach($keys as $key)
    {
			$output[]=array(
			  'text' => $key,
				'views' => $page_stats[0]['stats']['views'][$key],
				'visits' => $page_stats[0]['stats']['visits'][$key]
			);
		}
    break;
  case 'year':
    $monate = array(
      'Januar',
      'Februar',
      'März',
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
    $label = 'Jahr '.strftime('%Y',$page_stats[0]['stats']['info']['start']);
    $keys = array_keys($page_stats[0]['stats']['views']);
    foreach($keys as $key)
    {
			$t = explode('.',$key);
			$m = intval($t[0]) - 1;
			$output[]=array(
			  'text' => $monate[$m],
				'views' => $page_stats[0]['stats']['views'][$key],
				'visits' => $page_stats[0]['stats']['visits'][$key]
			);
		}
    break;
}
$smarty->assign('statslabel',$label);
$smarty->assign('statsdata',$output);

?>
