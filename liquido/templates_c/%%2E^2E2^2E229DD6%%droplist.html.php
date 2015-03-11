<?php /* Smarty version 2.6.9, created on 2010-09-28 09:14:59
         compiled from /Webserver/vwclub.local/htdocs/liquido/modules/content_stats/templates/droplist.html */ ?>
<select name="range" id="range" onchange="submit()">
  <option value="week" <?php if ($this->_tpl_vars['range'] == 'week'): ?>selected<?php endif; ?>>Woche</option>
  <option value="month" <?php if ($this->_tpl_vars['range'] == 'month'): ?>selected<?php endif; ?>>Monat</option>
  <option value="year" <?php if ($this->_tpl_vars['range'] == 'year'): ?>selected<?php endif; ?>>Jahr</option>
</select>