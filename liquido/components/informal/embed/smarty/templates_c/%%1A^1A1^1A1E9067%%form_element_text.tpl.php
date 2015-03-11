<?php /* Smarty version 2.6.8, created on 2005-11-11 00:18:03
         compiled from /var/www/meinhard/informal-0.7.0/themes/default/public/form_element_text.tpl */ ?>
<div class="form-element-title">
<?php echo $this->_tpl_vars['title']; ?>

<?php if ($this->_tpl_vars['required']): ?><span class="required">required</span><?php endif;  if ($this->_tpl_vars['error']): ?><span class="field_error_message"> &ndash; <?php echo $this->_tpl_vars['error']; ?>
</span><?php endif; ?>
</div>
<?php echo $this->_tpl_vars['input_field']; ?>
<br />
<div class="form-element-description"><?php echo $this->_tpl_vars['description']; ?>
</div>