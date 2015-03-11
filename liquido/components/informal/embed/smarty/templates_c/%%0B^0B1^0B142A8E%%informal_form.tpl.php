<?php /* Smarty version 2.6.8, created on 2006-02-16 16:40:41
         compiled from public/informal_form.tpl */ ?>
<form<?php echo $this->_tpl_vars['attributes']; ?>
>
<?php unset($this->_sections['fe']);
$this->_sections['fe']['name'] = 'fe';
$this->_sections['fe']['loop'] = is_array($_loop=$this->_tpl_vars['form_elements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['fe']['show'] = true;
$this->_sections['fe']['max'] = $this->_sections['fe']['loop'];
$this->_sections['fe']['step'] = 1;
$this->_sections['fe']['start'] = $this->_sections['fe']['step'] > 0 ? 0 : $this->_sections['fe']['loop']-1;
if ($this->_sections['fe']['show']) {
    $this->_sections['fe']['total'] = $this->_sections['fe']['loop'];
    if ($this->_sections['fe']['total'] == 0)
        $this->_sections['fe']['show'] = false;
} else
    $this->_sections['fe']['total'] = 0;
if ($this->_sections['fe']['show']):

            for ($this->_sections['fe']['index'] = $this->_sections['fe']['start'], $this->_sections['fe']['iteration'] = 1;
                 $this->_sections['fe']['iteration'] <= $this->_sections['fe']['total'];
                 $this->_sections['fe']['index'] += $this->_sections['fe']['step'], $this->_sections['fe']['iteration']++):
$this->_sections['fe']['rownum'] = $this->_sections['fe']['iteration'];
$this->_sections['fe']['index_prev'] = $this->_sections['fe']['index'] - $this->_sections['fe']['step'];
$this->_sections['fe']['index_next'] = $this->_sections['fe']['index'] + $this->_sections['fe']['step'];
$this->_sections['fe']['first']      = ($this->_sections['fe']['iteration'] == 1);
$this->_sections['fe']['last']       = ($this->_sections['fe']['iteration'] == $this->_sections['fe']['total']);
?>
<div class="formElement"><?php echo $this->_tpl_vars['form_elements'][$this->_sections['fe']['index']]['html']; ?>
</div>
<?php endfor; endif; ?>
</form>