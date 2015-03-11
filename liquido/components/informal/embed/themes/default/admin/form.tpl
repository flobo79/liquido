{if $form.errors}
<p class="error">Fehler: Nicht alle Felder wurden korrekt ausgef&uuml;llt, bitte pr&uuml;fen
  Sie Ihre Eingaben. </p>
{/if}

{if $message}
<p class="message">{$message}</p>
{/if}

<form{$form.attributes}>
<p class="formElement">
{section name=e loop=$form.elements}
{if $form.elements[e].label}
{$form.elements[e].label}
{if $form.elements[e].required}
<span class="required">required</span>
{/if}
{if $form.elements[e].error}
<span class="field_error_message">&ndash; {$form.elements[e].error}</span>
{/if}
<br />
{/if}
{*display grouped elements together*}
{if $form.elements[e].type == 'group'}
{section name=inner loop=$form.elements[e].elements}
{$form.elements[e].elements[inner].html}{$form.elements[e].separator}
{/section}
{else}
{$form.elements[e].html}
{/if}
{* no separator at hidden field or after the last field *}
{if not $smarty.section.e.last and $form.elements[e].type != "hidden"}
<br />
<br />
{/if}
{/section}
</p>
</form>
