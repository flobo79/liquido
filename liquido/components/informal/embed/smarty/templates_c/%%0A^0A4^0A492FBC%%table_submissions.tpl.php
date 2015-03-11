<?php /* Smarty version 2.6.8, created on 2005-10-12 16:17:33
         compiled from admin/table_submissions.tpl */ ?>

<div class="padding">
<table border="1">

<tr>
<?php if ($this->_tpl_vars['show_line_numbering'] == 'yes'): ?>
<th>#</th>
<?php endif;  if ($this->_tpl_vars['show_actions'] == 'yes'): ?>
<th>Actions</th>
<?php endif;  if ($this->_tpl_vars['show_timestamp'] == 'yes'): ?>
<th><a href="<?php echo $this->_tpl_vars['th_time_link']; ?>
">Time</a></th>
<?php endif;  unset($this->_sections['f']);
$this->_sections['f']['name'] = 'f';
$this->_sections['f']['loop'] = is_array($_loop=$this->_tpl_vars['formfields']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['f']['show'] = true;
$this->_sections['f']['max'] = $this->_sections['f']['loop'];
$this->_sections['f']['step'] = 1;
$this->_sections['f']['start'] = $this->_sections['f']['step'] > 0 ? 0 : $this->_sections['f']['loop']-1;
if ($this->_sections['f']['show']) {
    $this->_sections['f']['total'] = $this->_sections['f']['loop'];
    if ($this->_sections['f']['total'] == 0)
        $this->_sections['f']['show'] = false;
} else
    $this->_sections['f']['total'] = 0;
if ($this->_sections['f']['show']):

            for ($this->_sections['f']['index'] = $this->_sections['f']['start'], $this->_sections['f']['iteration'] = 1;
                 $this->_sections['f']['iteration'] <= $this->_sections['f']['total'];
                 $this->_sections['f']['index'] += $this->_sections['f']['step'], $this->_sections['f']['iteration']++):
$this->_sections['f']['rownum'] = $this->_sections['f']['iteration'];
$this->_sections['f']['index_prev'] = $this->_sections['f']['index'] - $this->_sections['f']['step'];
$this->_sections['f']['index_next'] = $this->_sections['f']['index'] + $this->_sections['f']['step'];
$this->_sections['f']['first']      = ($this->_sections['f']['iteration'] == 1);
$this->_sections['f']['last']       = ($this->_sections['f']['iteration'] == $this->_sections['f']['total']);
?>
<th><a href="<?php echo $this->_tpl_vars['formfields'][$this->_sections['f']['index']]['link']; ?>
"><?php echo $this->_tpl_vars['formfields'][$this->_sections['f']['index']]['name']; ?>
</a></th>
<?php endfor; endif; ?>
</tr>

<?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=$this->_tpl_vars['submissions']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['show'] = true;
$this->_sections['s']['max'] = $this->_sections['s']['loop'];
$this->_sections['s']['step'] = 1;
$this->_sections['s']['start'] = $this->_sections['s']['step'] > 0 ? 0 : $this->_sections['s']['loop']-1;
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = $this->_sections['s']['loop'];
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
?>
<tr>
<?php if ($this->_tpl_vars['show_line_numbering'] == 'yes'): ?>
<td align="right"><?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['number']; ?>
</td>
<?php endif;  if ($this->_tpl_vars['show_actions'] == 'yes'): ?>
<td><a href="<?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['link_view']; ?>
">View</a> <a href="<?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['link_edit']; ?>
">Edit</a> <a href="<?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['link_del']; ?>
">Del</a></td>
<?php endif;  if ($this->_tpl_vars['show_timestamp'] == 'yes'): ?>
<td><?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['timestamp']; ?>
</td>
<?php endif;  unset($this->_sections['f']);
$this->_sections['f']['name'] = 'f';
$this->_sections['f']['loop'] = is_array($_loop=$this->_tpl_vars['submissions'][$this->_sections['s']['index']]['fields']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['f']['show'] = true;
$this->_sections['f']['max'] = $this->_sections['f']['loop'];
$this->_sections['f']['step'] = 1;
$this->_sections['f']['start'] = $this->_sections['f']['step'] > 0 ? 0 : $this->_sections['f']['loop']-1;
if ($this->_sections['f']['show']) {
    $this->_sections['f']['total'] = $this->_sections['f']['loop'];
    if ($this->_sections['f']['total'] == 0)
        $this->_sections['f']['show'] = false;
} else
    $this->_sections['f']['total'] = 0;
if ($this->_sections['f']['show']):

            for ($this->_sections['f']['index'] = $this->_sections['f']['start'], $this->_sections['f']['iteration'] = 1;
                 $this->_sections['f']['iteration'] <= $this->_sections['f']['total'];
                 $this->_sections['f']['index'] += $this->_sections['f']['step'], $this->_sections['f']['iteration']++):
$this->_sections['f']['rownum'] = $this->_sections['f']['iteration'];
$this->_sections['f']['index_prev'] = $this->_sections['f']['index'] - $this->_sections['f']['step'];
$this->_sections['f']['index_next'] = $this->_sections['f']['index'] + $this->_sections['f']['step'];
$this->_sections['f']['first']      = ($this->_sections['f']['iteration'] == 1);
$this->_sections['f']['last']       = ($this->_sections['f']['iteration'] == $this->_sections['f']['total']);
?>
<td><a href="<?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['fields'][$this->_sections['f']['index']]['link']; ?>
" class="linkBlind"><?php echo $this->_tpl_vars['submissions'][$this->_sections['s']['index']]['fields'][$this->_sections['f']['index']]['name']; ?>
</a></td>
<?php endfor; endif; ?>
</tr>
<?php endfor; endif; ?>

</table>
</div>
