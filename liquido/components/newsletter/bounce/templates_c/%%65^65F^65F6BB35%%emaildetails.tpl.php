<?php /* Smarty version 2.6.9, created on 2005-08-18 11:52:11
         compiled from emaildetails.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'emaildetails.tpl', 33, false),array('modifier', 'nl2br', 'emaildetails.tpl', 40, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Übersicht</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<?php echo $this->_tpl_vars['xajax_javascript']; ?>

<script type="text/javascript">
<!--

function deletemail()
{
	alert('<?php echo $this->_tpl_vars['id']; ?>
');
	xajax_deletemail(<?php echo $this->_tpl_vars['id']; ?>
);
	//opener.location.reload();
	//window.close();
}

function deletesubscriber()
{
<?php if ($this->_tpl_vars['adressat']): ?>
	alert('<?php echo $this->_tpl_vars['adressat']; ?>
');
	xajax_deletemail('<?php echo $this->_tpl_vars['adressat']; ?>
');
<?php endif; ?>
}

//-->
</script>
</head>

<body>
<h1>E-Mail Details</h1>
<p>Betreff: <?php echo ((is_array($_tmp=$this->_tpl_vars['betreff'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
 <br />
  Von: <?php echo ((is_array($_tmp=$this->_tpl_vars['from'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
<br />
  Datum: <?php echo $this->_tpl_vars['datum']; ?>
<br />
An: <?php echo ((is_array($_tmp=$this->_tpl_vars['to'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</p>
<p>Grund: <?php if ($this->_tpl_vars['grund']):  echo $this->_tpl_vars['grund'];  else: ?>unbekannt<?php endif; ?><br />
  Abonnent: <?php if ($this->_tpl_vars['adressat']):  echo $this->_tpl_vars['adressat'];  else: ?>kein Abonnent!<?php endif; ?>
</p>
<code><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['body'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</code>
<p>
  <input name="close" type="button" id="close" value="Schlie&szlig;en" onclick="javascript:window.close();" />
  <input name="deletemail" type="button" id="deletemail" value="Email l&ouml;schen" onclick="javascript:deletemail();" />
<?php if ($this->_tpl_vars['adressat']): ?>
  <input name="deletesubscriber" type="button" id="deletesubscriber" value="Abonnent l&ouml;schen" onclick="javascript:deletesubscriber();" />
<?php endif; ?>
</p>
</body>
</html>