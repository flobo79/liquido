<?php /* Smarty version 2.6.9, created on 2010-09-28 09:14:59
         compiled from /Webserver/vwclub.local/htdocs/liquido/modules/content_stats/templates/js-kalender.html */ ?>
<script type="text/javascript">
  function dateChanged(calendar) {
	if (calendar.dateClicked) {
	  statistic.timestamp.value = calendar.date.getTime() / 1000;
	  statistic.submit();
	}
  };
</script>
<div id="statscalendar"></div>
<script type="text/javascript">
var caldate = new Date("<?php echo $this->_tpl_vars['parsedate']; ?>
");
Calendar.setup({"ifFormat":"%Y/%m/%d","daFormat":"%Y/%m/%d","flat":"statscalendar","firstDay":1,"date":caldate,"flatCallback":dateChanged});
</script>
<input name="timestamp" type="hidden" id="timestamp" value="<?php echo $this->_tpl_vars['timestamp']; ?>
" />