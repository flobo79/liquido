<h2>Edit Form Element</h2>
<div class="formElement">
<form action="{$action_url}" method="post">
Name <br />
<input type="text" size="50" maxlength="255" name="name" value="{$element_name}" /><br />
Position <br />
<input type="text" name="position" size="2" maxlength="3" value="{$element_position}" /><br />
Mandatory <br />
<input type="radio" name="mandatory" value="Y"{$mandatory_y_checked} /> Y<br />
<input type="radio" name="mandatory" value="N"{$mandatory_n_checked} /> N<br />
Publicly visible<br />
<input type="radio" name="public" value="Y"{$public_y_checked} /> Y<br />
<input type="radio" name="public" value="N"{$public_n_checked} /> N<br />
Check for valid email address<br />
<input type="radio" name="test_email" value="Y"{$check_email_y_checked} /> Y<br />
<input type="radio" name="test_email" value="N"{$check_email_n_checked} /> N<br />
<hr />
{include file="admin/form_options.tpl"}
<br />
<textarea name="options" cols="50" rows="5">{$element_options}</textarea><br /><br />
<input type="hidden" name="el_id" value="{$el_id}" />
<input type="hidden" name="referer" value="{$referer_url}" />
<input type="submit" name="ok" value="OK" class="submitButton" />
<input type="submit" name="cancel" value="Cancel" class="submitButton" />
</form>
</div>
