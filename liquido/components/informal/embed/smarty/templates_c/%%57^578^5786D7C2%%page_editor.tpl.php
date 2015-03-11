<?php /* Smarty version 2.6.8, created on 2005-11-11 01:34:34
         compiled from /www/i.benn.org/htdocs/themes/default/admin/page_editor.tpl */ ?>


<h2>Add form element</h2>

<div class="formElement">
<form action="<?php echo $this->_tpl_vars['form_element_add_action']; ?>
" method="get">
<div>
<input type="hidden" name="f" value="<?php echo $this->_tpl_vars['form_id']; ?>
" />
<input type="hidden" name="a" value="<?php echo $this->_tpl_vars['area']; ?>
" />
<input type="hidden" name="p" value="<?php echo $this->_tpl_vars['page']; ?>
" />
<select name="type">
<?php unset($this->_sections['e']);
$this->_sections['e']['name'] = 'e';
$this->_sections['e']['loop'] = is_array($_loop=$this->_tpl_vars['available_elements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['e']['show'] = true;
$this->_sections['e']['max'] = $this->_sections['e']['loop'];
$this->_sections['e']['step'] = 1;
$this->_sections['e']['start'] = $this->_sections['e']['step'] > 0 ? 0 : $this->_sections['e']['loop']-1;
if ($this->_sections['e']['show']) {
    $this->_sections['e']['total'] = $this->_sections['e']['loop'];
    if ($this->_sections['e']['total'] == 0)
        $this->_sections['e']['show'] = false;
} else
    $this->_sections['e']['total'] = 0;
if ($this->_sections['e']['show']):

            for ($this->_sections['e']['index'] = $this->_sections['e']['start'], $this->_sections['e']['iteration'] = 1;
                 $this->_sections['e']['iteration'] <= $this->_sections['e']['total'];
                 $this->_sections['e']['index'] += $this->_sections['e']['step'], $this->_sections['e']['iteration']++):
$this->_sections['e']['rownum'] = $this->_sections['e']['iteration'];
$this->_sections['e']['index_prev'] = $this->_sections['e']['index'] - $this->_sections['e']['step'];
$this->_sections['e']['index_next'] = $this->_sections['e']['index'] + $this->_sections['e']['step'];
$this->_sections['e']['first']      = ($this->_sections['e']['iteration'] == 1);
$this->_sections['e']['last']       = ($this->_sections['e']['iteration'] == $this->_sections['e']['total']);
?>
  <option value="<?php echo $this->_tpl_vars['available_elements'][$this->_sections['e']['index']]['name']; ?>
"><?php echo $this->_tpl_vars['available_elements'][$this->_sections['e']['index']]['title']; ?>
</option>
<?php endfor; endif; ?>
</select>
<input type="submit" value="+ Add" class="submitButton" />
</div>
</form>
</div>

<h2>Edit form elements</h2>

<?php if ($this->_tpl_vars['form_elements']): ?>
<div class="formElement">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/informal_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php else: ?>
<div class="formElement">
Das Formular enthält noch keine Elemente.
</div>
<?php endif; ?>