{if $element_type == "design_text"}
Text<br />
<textarea name="options-text" cols="50" rows=5>{$options.text}</textarea><br />
{/if}
{if $element_type == "radio"}
Choices<br />
{section name=o loop=$options.options}
<input type="text" value="{$options.options[o]}"><br />
{/section}
Selected<br />
<input type="text" value="{$options.selected}"><br />
{/if}
