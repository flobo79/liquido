<h2>Add {$element_name}</h2>
<div class="formElement">
<form action="{$action_url}" method="post">
Name <br />
<input type="text" size="50" maxlength="255" name="name" /><br />
Position <br />
<input type="text" name="position" size="2" maxlength="3" /><br />
Mandatory <br />
<input type="radio" name="mandatory" value="Y" /> Y<br />
<input type="radio" name="mandatory" value="N" checked="checked" /> N<br />
Publicly visible <br />
<input type="radio" name="public" value="Y" checked="checked" /> Y<br />
<input type="radio" name="public" value="N" /> N<br />
Check for valid email address <br />
<input type="radio" name="test_email" value="Y" /> Y<br />
<input type="radio" name="test_email" value="N" checked="checked" /> N<br />
Options<br />
<textarea name="options" cols="50" rows="5">{$element_options}</textarea><br /><br />
<input type="hidden" name="action" value="add" />
<input type="hidden" name="form_element_id" value="{$form_element_id}" />
<input type="hidden" name="referer" value="{$referer_url}" />
<input type="submit" name="add" value="Add" class="submitButton" />
<input type="submit" name="cancel" value="Cancel" class="submitButton" />
</form>
</div>
