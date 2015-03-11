<?php /* Smarty version 2.6.8, created on 2005-10-16 04:30:38
         compiled from admin/form_options.tpl */ ?>
<?php if ($this->_tpl_vars['element_type'] == 'design_text'): ?>
Text<br />
<textarea name="options-text" cols="50" rows=5><?php echo $this->_tpl_vars['options']['text']; ?>
</textarea><br />
<?php endif;  if ($this->_tpl_vars['element_type'] == 'radio'): ?>
Choices<br />
<?php unset($this->_sections['o']);
$this->_sections['o']['name'] = 'o';
$this->_sections['o']['loop'] = is_array($_loop=$this->_tpl_vars['options']['options']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['o']['show'] = true;
$this->_sections['o']['max'] = $this->_sections['o']['loop'];
$this->_sections['o']['step'] = 1;
$this->_sections['o']['start'] = $this->_sections['o']['step'] > 0 ? 0 : $this->_sections['o']['loop']-1;
if ($this->_sections['o']['show']) {
    $this->_sections['o']['total'] = $this->_sections['o']['loop'];
    if ($this->_sections['o']['total'] == 0)
        $this->_sections['o']['show'] = false;
} else
    $this->_sections['o']['total'] = 0;
if ($this->_sections['o']['show']):

            for ($this->_sections['o']['index'] = $this->_sections['o']['start'], $this->_sections['o']['iteration'] = 1;
                 $this->_sections['o']['iteration'] <= $this->_sections['o']['total'];
                 $this->_sections['o']['index'] += $this->_sections['o']['step'], $this->_sections['o']['iteration']++):
$this->_sections['o']['rownum'] = $this->_sections['o']['iteration'];
$this->_sections['o']['index_prev'] = $this->_sections['o']['index'] - $this->_sections['o']['step'];
$this->_sections['o']['index_next'] = $this->_sections['o']['index'] + $this->_sections['o']['step'];
$this->_sections['o']['first']      = ($this->_sections['o']['iteration'] == 1);
$this->_sections['o']['last']       = ($this->_sections['o']['iteration'] == $this->_sections['o']['total']);
?>
<input type="text" value="<?php echo $this->_tpl_vars['options']['options'][$this->_sections['o']['index']]; ?>
"><br />
<?php endfor; endif; ?>
Selected<br />
<input type="text" value="<?php echo $this->_tpl_vars['options']['selected']; ?>
"><br />
<?php endif; ?>