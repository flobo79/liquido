<?php /* Smarty version 2.6.9, created on 2010-09-28 09:14:59
         compiled from /Webserver/vwclub.local/htdocs/liquido/modules/content_stats/templates/statistik.html */ ?>
<form action="" method="post" enctype="application/x-www-form-urlencoded" name="statistic">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['docroot']).($this->_tpl_vars['LIQUIDO'])."/modules/content_stats/templates/pagedetails.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

zeige Zeitraum: <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['docroot']).($this->_tpl_vars['LIQUIDO'])."/modules/content_stats/templates/droplist.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['docroot']).($this->_tpl_vars['LIQUIDO'])."/modules/content_stats/templates/js-kalender.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</form>