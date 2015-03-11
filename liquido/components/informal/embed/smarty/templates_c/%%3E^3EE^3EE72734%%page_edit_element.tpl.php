<?php /* Smarty version 2.6.8, created on 2005-10-16 04:18:46
         compiled from admin/page_edit_element.tpl */ ?>
<h2>Edit Form Element</h2>
<div class="formElement">
<form action="<?php echo $this->_tpl_vars['action_url']; ?>
" method="post">
Name <br />
<input type="text" size="50" maxlength="255" name="name" value="<?php echo $this->_tpl_vars['element_name']; ?>
" /><br />
Position <br />
<input type="text" name="position" size="2" maxlength="3" value="<?php echo $this->_tpl_vars['element_position']; ?>
" /><br />
Mandatory <br />
<input type="radio" name="mandatory" value="Y"<?php echo $this->_tpl_vars['mandatory_y_checked']; ?>
 /> Y<br />
<input type="radio" name="mandatory" value="N"<?php echo $this->_tpl_vars['mandatory_n_checked']; ?>
 /> N<br />
Publicly visible<br />
<input type="radio" name="public" value="Y"<?php echo $this->_tpl_vars['public_y_checked']; ?>
 /> Y<br />
<input type="radio" name="public" value="N"<?php echo $this->_tpl_vars['public_n_checked']; ?>
 /> N<br />
Check for valid email address<br />
<input type="radio" name="test_email" value="Y"<?php echo $this->_tpl_vars['check_email_y_checked']; ?>
 /> Y<br />
<input type="radio" name="test_email" value="N"<?php echo $this->_tpl_vars['check_email_n_checked']; ?>
 /> N<br />
<hr />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/form_options.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br />
<textarea name="options" cols="50" rows="5"><?php echo $this->_tpl_vars['element_options']; ?>
</textarea><br /><br />
<input type="hidden" name="el_id" value="<?php echo $this->_tpl_vars['el_id']; ?>
" />
<input type="hidden" name="referer" value="<?php echo $this->_tpl_vars['referer_url']; ?>
" />
<input type="submit" name="ok" value="OK" class="submitButton" />
<input type="submit" name="cancel" value="Cancel" class="submitButton" />
</form>
</div>