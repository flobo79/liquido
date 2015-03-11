

<h2>Add form element</h2>

<div class="formElement">
{*
  this needs to be a "get" action form unfortunately, because if it's a "post"
  form the pear quickform form at the action target thinks it already got a
  submission and tries to validate. does anyone know a nicer solution?
*}
<form action="{$form_element_add_action}" method="get">
<div>
<input type="hidden" name="f" value="{$form_id}" />
<input type="hidden" name="a" value="{$area}" />
<input type="hidden" name="p" value="{$page}" />
<select name="type">
{section name=e loop=$available_elements}
  <option value="{$available_elements[e].name}">{$available_elements[e].title}</option>
{/section}
</select>
<input type="submit" value="+ Add" class="submitButton" />
</div>
</form>
</div>

<h2>Edit form elements</h2>

{if $form_elements}
<div class="formElement">
{include file="admin/informal_form.tpl"}
</div>
{else}
<div class="formElement">
Das Formular enthält noch keine Elemente.
</div>
{/if}
