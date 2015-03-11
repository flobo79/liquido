<form action="">
{section name=fe loop=$form_elements}
<div class="editor">
  <div class="html">{$form_elements[fe].html}</div>
  <div class="editor-functions">
    <span class="buttons">
{if $form_elements[fe].edit_link}
      <a href="{$form_elements[fe].edit_link}" class="button">&ne; Edit</a>
{else}
      <span class="button-inactive">&ne; Edit</span>
{/if}
{if $smarty.section.fe.first}
      <span class="button-inactive">&uarr; Up</span>
{else}
      <a href="{$form_elements[fe].move_up_link}" class="button">&uarr; Up</a>
{/if}
{if $smarty.section.fe.last}
      <span class="button-inactive">&darr; Dwn</span>
{else}
      <a href="{$form_elements[fe].move_down_link}" class="button">&darr; Dwn</a>
{/if}
      <a href="{$form_elements[fe].remove_link}" class="button">&times; Del</a>
    </span>
    <span class="details">Type: {$form_elements[fe].type_title} | id: {$form_elements[fe].id}</span>
  </div>
</div>
{/section}
</form>
