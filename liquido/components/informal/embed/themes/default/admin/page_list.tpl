<div class="formElement">
Access a public submission form by clicking on its name. If you are the
administrator of a form, click the "Admin" link next to the form name.
<ul>
{section name=f loop=$forms}
  <li><a href="{$forms[f].link}">{$forms[f].name}</a>
      <a class="button-smaller" href="{$forms[f].admin_link}">Manage</a>
      <a class="button-smaller" href="{$forms[f].delete_link}">Delete</a>
  </li>
{/section}
</ul>
</div>
<p><a href="{$form_add_link}">Add new form</a></p>

{* <p>
<a href="{$informal_admin_link}">Informal Administrator Login</a>
</p> *}
