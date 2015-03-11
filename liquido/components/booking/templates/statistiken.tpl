{if false}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Statistiken</title>
<link href="../booking.css" rel="stylesheet" type="text/css" />
</head>

<body>
{/if}
<script language="JavaScript" type="text/javascript">
	function loadstats_year(jahr) {ldelim}
		document.year.src='gfx/stats_dates_year.php?jahr='+jahr;
	{rdelim}
	function loadstats_places(monat,jahr) {ldelim}
		document.month.src='gfx/stats_dates_place.php?jahr='+jahr+'&monat='+monat;
	{rdelim}
</script>
<div align="center">
<form name="stats" id="stats" method="post" action="">
  Zeitraum w&auml;hlen: 
  <select name="select_year1" id="select_year1" onchange="javascript:loadstats_year(this.value);">
	{html_options options=$jahre selected=$jahr}
  </select>
  <p><img src="gfx/stats_dates_year.php" id="year" name="year" /></p>
  Zeitraum w&auml;hlen: 
  <select name="select_month1" id="select_month1" onchange="javascript:loadstats_places(this.value,document.stats.select_year2.value);">
	{html_options options=$monate selected=$monat}
  </select>
  <select name="select_year2" id="select_year2" onchange="javascript:loadstats_places(document.stats.select_month1.value,this.value);">
	{html_options options=$jahre selected=$jahr}
  </select>
  <p><img src="gfx/stats_dates_place.php" id="month" name="month" /></p>
</form>
</div>
{if false}
</body>
</html>
{/if}
