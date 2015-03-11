<h2>View submissions</h2>
<div class="formElement">
<ul>
{section name=list loop=$lists}
  <li><a href="{$lists[list].link}">{$lists[list].name}</a></li>
{/section}
</ul>
</div>
