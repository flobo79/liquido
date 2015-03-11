<?php /* Smarty version 2.6.8, created on 2005-11-10 17:22:22
         compiled from /var/www/meinhard/informal-0.7.0/themes/default/admin/form.tpl */ ?>
<?php if ($this->_tpl_vars['form']['errors']): ?>
<p class="error">Error: Not all required fields were filled out correctly. Please check your input.</a>
<?php endif; ?>

<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<p class="formElement">
<?php unset($this->_sections['e']);
$this->_sections['e']['name'] = 'e';
$this->_sections['e']['loop'] = is_array($_loop=$this->_tpl_vars['form']['elements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 if ($this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['label']):  echo $this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['label']; ?>

<?php if ($this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['required']): ?>
<span class="required">required</span>
<?php endif;  if ($this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['error']): ?>
<span class="field_error_message">&ndash; <?php echo $this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['error']; ?>
</span>
<?php endif; ?>
<br />
<?php endif;  if ($this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['type'] == 'group'):  unset($this->_sections['inner']);
$this->_sections['inner']['name'] = 'inner';
$this->_sections['inner']['loop'] = is_array($_loop=$this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['elements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['inner']['show'] = true;
$this->_sections['inner']['max'] = $this->_sections['inner']['loop'];
$this->_sections['inner']['step'] = 1;
$this->_sections['inner']['start'] = $this->_sections['inner']['step'] > 0 ? 0 : $this->_sections['inner']['loop']-1;
if ($this->_sections['inner']['show']) {
    $this->_sections['inner']['total'] = $this->_sections['inner']['loop'];
    if ($this->_sections['inner']['total'] == 0)
        $this->_sections['inner']['show'] = false;
} else
    $this->_sections['inner']['total'] = 0;
if ($this->_sections['inner']['show']):

            for ($this->_sections['inner']['index'] = $this->_sections['inner']['start'], $this->_sections['inner']['iteration'] = 1;
                 $this->_sections['inner']['iteration'] <= $this->_sections['inner']['total'];
                 $this->_sections['inner']['index'] += $this->_sections['inner']['step'], $this->_sections['inner']['iteration']++):
$this->_sections['inner']['rownum'] = $this->_sections['inner']['iteration'];
$this->_sections['inner']['index_prev'] = $this->_sections['inner']['index'] - $this->_sections['inner']['step'];
$this->_sections['inner']['index_next'] = $this->_sections['inner']['index'] + $this->_sections['inner']['step'];
$this->_sections['inner']['first']      = ($this->_sections['inner']['iteration'] == 1);
$this->_sections['inner']['last']       = ($this->_sections['inner']['iteration'] == $this->_sections['inner']['total']);
 echo $this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['elements'][$this->_sections['inner']['index']]['html'];  echo $this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['separator']; ?>

<?php endfor; endif;  else:  echo $this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['html']; ?>

<?php endif;  if (! $this->_sections['e']['last'] && $this->_tpl_vars['form']['elements'][$this->_sections['e']['index']]['type'] != 'hidden'): ?>
<br />
<br />
<?php endif;  endfor; endif; ?>
</p>
</form>