
<div class="right_pane">
    <div class="right_pane_top"></div>
    <div class="right_pane_content">
        <h3>Element hinzuf&uuml;gen</h3>
        <ul>
        {section name=e loop=$available_elements}<li><a href="{$form_element_add_action}&amp;type={$available_elements[e].name}">{$available_elements[e].title}</a></li>
        {/section}</ul>
    </div>
    <div class="right_pane_bottom"></div>
</div>

<div class="informal-composer">
    {if $form_elements}
    <div class="formElement">
        {include file="admin/informal_form.tpl"}
    </div>
    {else}
    <div class="formElement">
        Das Formular enthält noch keine Objekte.
    </div>
    {/if}
</div>
