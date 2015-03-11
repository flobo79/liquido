<?php /* Smarty version 2.6.8, created on 2005-11-11 01:05:02
         compiled from /var/www/meinhard/informal-0.7.0/themes/default/admin/page_list.tpl */ ?>
<h2>Welcome to the informal headquarter</h2>
<div class="formElement">
Access a public submission form by clicking on its name. If you are the
administrator of a form, click the "Admin" link next to the form name.
<ul>
<?php unset($this->_sections['f']);
$this->_sections['f']['name'] = 'f';
$this->_sections['f']['loop'] = is_array($_loop=$this->_tpl_vars['forms']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
  <li><a href="<?php echo $this->_tpl_vars['forms'][$this->_sections['f']['index']]['link']; ?>
"><?php echo $this->_tpl_vars['forms'][$this->_sections['f']['index']]['name']; ?>
</a> <a class="button-smaller" href="<?php echo $this->_tpl_vars['forms'][$this->_sections['f']['index']]['admin_link']; ?>
">Edit</a></li>
<?php endfor; endif; ?>
</ul>
</div>