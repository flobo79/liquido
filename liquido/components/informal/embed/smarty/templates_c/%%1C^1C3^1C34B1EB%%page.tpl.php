<?php /* Smarty version 2.6.8, created on 2005-11-11 01:24:51
         compiled from /www/i.benn.org/htdocs/themes/default/admin/page.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo $this->_tpl_vars['title']; ?>
</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_link']; ?>
" />
</head>
<body>

<h1 class="pageHeader"><?php echo $this->_tpl_vars['headline']; ?>
</h1>

<div class="menu">
<?php if ($this->_tpl_vars['username']): ?>
  <ul>
    <?php unset($this->_sections['m']);
$this->_sections['m']['name'] = 'm';
$this->_sections['m']['loop'] = is_array($_loop=$this->_tpl_vars['menu_items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['m']['show'] = true;
$this->_sections['m']['max'] = $this->_sections['m']['loop'];
$this->_sections['m']['step'] = 1;
$this->_sections['m']['start'] = $this->_sections['m']['step'] > 0 ? 0 : $this->_sections['m']['loop']-1;
if ($this->_sections['m']['show']) {
    $this->_sections['m']['total'] = $this->_sections['m']['loop'];
    if ($this->_sections['m']['total'] == 0)
        $this->_sections['m']['show'] = false;
} else
    $this->_sections['m']['total'] = 0;
if ($this->_sections['m']['show']):

            for ($this->_sections['m']['index'] = $this->_sections['m']['start'], $this->_sections['m']['iteration'] = 1;
                 $this->_sections['m']['iteration'] <= $this->_sections['m']['total'];
                 $this->_sections['m']['index'] += $this->_sections['m']['step'], $this->_sections['m']['iteration']++):
$this->_sections['m']['rownum'] = $this->_sections['m']['iteration'];
$this->_sections['m']['index_prev'] = $this->_sections['m']['index'] - $this->_sections['m']['step'];
$this->_sections['m']['index_next'] = $this->_sections['m']['index'] + $this->_sections['m']['step'];
$this->_sections['m']['first']      = ($this->_sections['m']['iteration'] == 1);
$this->_sections['m']['last']       = ($this->_sections['m']['iteration'] == $this->_sections['m']['total']);
?><li><a href="<?php echo $this->_tpl_vars['menu_items'][$this->_sections['m']['index']]['link']; ?>
"><?php echo $this->_tpl_vars['menu_items'][$this->_sections['m']['index']]['title']; ?>
</a></li><?php endfor; endif; ?>

  </ul>
<?php endif; ?>
</div>

<?php echo $this->_tpl_vars['content']; ?>


</body>
</html>