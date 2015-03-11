<?php /* Smarty version 2.6.9, created on 2005-08-26 17:21:56
         compiled from uebersicht.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'uebersicht.tpl', 33, false),array('modifier', 'escape', 'uebersicht.tpl', 35, false),array('modifier', 'default', 'uebersicht.tpl', 36, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Übersicht</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function openmail(id)
{
	MM_openBrWindow('emaildetails.php?emailid='+id,'emaildetails','scrollbars=yes,resizable=yes,width=400,height=500');
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<h1>&Uuml;bersicht der nicht zustellbaren Mails</h1>
<p>
  <table width="100%">
    <tr>
      <th>&nbsp;</th>
      <!--<th>Von</th>-->
      <th>Adressat</th>
      <th>Grund</th>
      <th>Datum</th>
    </tr>
    <?php unset($this->_sections['r']);
$this->_sections['r']['name'] = 'r';
$this->_sections['r']['loop'] = is_array($_loop=$this->_tpl_vars['ruecklaeufer']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['r']['show'] = true;
$this->_sections['r']['max'] = $this->_sections['r']['loop'];
$this->_sections['r']['step'] = 1;
$this->_sections['r']['start'] = $this->_sections['r']['step'] > 0 ? 0 : $this->_sections['r']['loop']-1;
if ($this->_sections['r']['show']) {
    $this->_sections['r']['total'] = $this->_sections['r']['loop'];
    if ($this->_sections['r']['total'] == 0)
        $this->_sections['r']['show'] = false;
} else
    $this->_sections['r']['total'] = 0;
if ($this->_sections['r']['show']):

            for ($this->_sections['r']['index'] = $this->_sections['r']['start'], $this->_sections['r']['iteration'] = 1;
                 $this->_sections['r']['iteration'] <= $this->_sections['r']['total'];
                 $this->_sections['r']['index'] += $this->_sections['r']['step'], $this->_sections['r']['iteration']++):
$this->_sections['r']['rownum'] = $this->_sections['r']['iteration'];
$this->_sections['r']['index_prev'] = $this->_sections['r']['index'] - $this->_sections['r']['step'];
$this->_sections['r']['index_next'] = $this->_sections['r']['index'] + $this->_sections['r']['step'];
$this->_sections['r']['first']      = ($this->_sections['r']['iteration'] == 1);
$this->_sections['r']['last']       = ($this->_sections['r']['iteration'] == $this->_sections['r']['total']);
?>
    <tr class="<?php echo smarty_function_cycle(array('values' => "row1,row2"), $this);?>
" onclick="javascript:openmail(<?php echo $this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['id']; ?>
);">
      <td><input name="cb[<?php echo $this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['id']; ?>
]" type="checkbox" id="cb[<?php echo $this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['id']; ?>
]" value="1" /></td>
      <!--<td><?php echo ((is_array($_tmp=$this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['from'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')); ?>
</td>-->
      <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['adressat'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall') : smarty_modifier_escape($_tmp, 'htmlall')))) ? $this->_run_mod_handler('default', true, $_tmp, 'unbekannt') : smarty_modifier_default($_tmp, 'unbekannt')); ?>
</td>
      <td><?php echo $this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['grund']; ?>
</td>
      <td><?php echo $this->_tpl_vars['ruecklaeufer'][$this->_sections['r']['index']]['datum']; ?>
</td>
    </tr>
    <?php endfor; else: ?>
    <tr>
      <td colspan="4">Keine R&uuml;ckl&auml;ufer vorhanden.</td>
    </tr>
    <?php endif; ?>
  </table>
</p>
</body>
</html>