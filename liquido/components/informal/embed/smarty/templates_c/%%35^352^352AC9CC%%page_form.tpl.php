<?php /* Smarty version 2.6.8, created on 2006-05-01 14:22:45
         compiled from /srv/web2/htdocs/liquido/components/informal/embed/themes/default/public/page_form.tpl */ ?>
<?php if (! $this->_tpl_vars['done']): ?>
<?php if ($this->_tpl_vars['problems']): ?>
<p class="error">Ihre Eingaben sind nicht vollständig, bitte füllen Sie alle mit * markierten Felder aus</p>
<?php endif; ?>

<div class="form">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/informal_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</div>
<?php else: ?>
<p>
<?php echo $this->_tpl_vars['thank_you_message']; ?>

</p>
<p>
<?php if ($this->_tpl_vars['thank_you_url']): ?><a href="<?php echo $this->_tpl_vars['thank_you_url']; ?>
"><?php echo $this->_tpl_vars['thank_you_url']; ?>
</a><?php endif; ?>
</p>
<?php endif; ?>
