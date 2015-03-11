<h2>Add form element</h2>
<div class="formElement">
<form action="{$form_element_add_action}" method="post">
<select name="element_id">
{section name=element loop=$available_elements}
  <option value="{$available_elements[element].id}">{$available_elements[element].long_name}</option>
{/section}
</select>
<input type="submit" value="Add" class="submitButton" />
</form>
<form action="{$form_element_add_new_action}" method="get">
{section name=g loop=$getvars}
<input type="hidden" name="{$getvars[g].name}" value="{$getvars[g].value}" />
{/section}
<select name="type">
{section name=e loop=$available_elements_new}
  <option value="{$available_elements_new[e].name}">{$available_elements_new[e].title}</option>
{/section}
</select>
<input type="submit" value="Add" class="submitButton" />
</form>
</div>
<h2>Edit form element</h2>
<div class="formElement">
<form action="{$form_element_edit_action}" method="post">
<select name="el_id">
{section name=element loop=$form_elements}
  <option value="{$form_elements[element].id}">{$form_elements[element].name}</option>
{/section}
</select>
<input type="submit" value="Edit" class="submitButton" />
</form>
</div>

<h2>Remove form element</h2>
<div class="formElement">
<form action="{$form_element_remove_action}" method="post">
<select name="entryform_id">
{section name=element loop=$form_elements}
  <option value="{$form_elements[element].id}">{$form_elements[element].name}</option>
{/section}
</select>
<input type="submit" value="Remove" class="submitButton" />
</form>
</div>
