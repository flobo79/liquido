<h2>Delete form element</h2>
<div class="formElement">
Are you sure you want to delete this element ({$element_title}) from the form?
<br />
<br />
<form action="{$action_url}" method="post" />
<input type="hidden" name="element_id" value="{$element_id}" />
<input type="submit" name="yes" value="Yes, down the drain!" class="submitButton" />
<input type="submit" name="cancel" value="Cancel" class="submitButton" />
<input type="hidden" name="referer" value="{$referer_url}" />
</form>
</div>
