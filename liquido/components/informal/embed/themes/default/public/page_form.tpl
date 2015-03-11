{if not $done}
{if $problems}
<p class="error">Ihre Eingaben sind nicht vollständig, bitte füllen Sie alle mit * markierten Felder aus</p>
{/if}

<div class="form">
{include file="public/informal_form.tpl"}

</div>
{else}
<p>
{$thank_you_message}
</p>
<p>
{if $thank_you_url}<a href="{$thank_you_url}">{$thank_you_url}</a>{/if}
</p>
{/if}

