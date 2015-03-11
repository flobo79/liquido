<form{$attributes}>
{section name=fe loop=$form_elements}
<div class="formElement">{$form_elements[fe].html}</div>
{/section}
</form>
