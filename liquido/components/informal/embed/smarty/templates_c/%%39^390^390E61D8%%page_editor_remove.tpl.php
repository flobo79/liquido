<?php /* Smarty version 2.6.8, created on 2005-10-22 02:58:05
         compiled from /var/www/meinhard/informal-0.7.0/themes/default/admin/page_editor_remove.tpl */ ?>
<h2>Delete form element</h2>
<div class="formElement">
Are you sure you want to delete this element (<?php echo $this->_tpl_vars['element_title']; ?>
) from the form?
<br />
<br />
<form action="<?php echo $this->_tpl_vars['action_url']; ?>
" method="post" />
<input type="hidden" name="element_id" value="<?php echo $this->_tpl_vars['element_id']; ?>
" />
<input type="submit" name="yes" value="Yes, down the drain!" class="submitButton" />
<input type="submit" name="cancel" value="Cancel" class="submitButton" />
<input type="hidden" name="referer" value="<?php echo $this->_tpl_vars['referer_url']; ?>
" />
</form>
</div>