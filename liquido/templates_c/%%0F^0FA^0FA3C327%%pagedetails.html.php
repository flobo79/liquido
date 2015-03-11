<?php /* Smarty version 2.6.9, created on 2010-09-28 09:14:59
         compiled from /Webserver/vwclub.local/htdocs/liquido/modules/content_stats/templates/pagedetails.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/Webserver/vwclub.local/htdocs/liquido/modules/content_stats/templates/pagedetails.html', 9, false),array('modifier', 'escape', '/Webserver/vwclub.local/htdocs/liquido/modules/content_stats/templates/pagedetails.html', 10, false),)), $this); ?>
<?php echo $this->_tpl_vars['statslabel']; ?>

<table width="291" border="0" class="statstable">
  <tr>
    <td>&nbsp;</td>
    <td>Views</td>
    <td>Visits</td>
  </tr>
  <?php $_from = $this->_tpl_vars['statsdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['stat']):
?>
  <tr class="row<?php echo smarty_function_cycle(array('values' => "1,2"), $this);?>
">
    <td width="91"><?php echo $this->_tpl_vars['stat']['id'];  echo ((is_array($_tmp=$this->_tpl_vars['stat']['text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</td>
    <td width="89"><?php echo $this->_tpl_vars['stat']['views']; ?>
</td>
    <td width="89"><?php echo $this->_tpl_vars['stat']['visits']; ?>
</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>