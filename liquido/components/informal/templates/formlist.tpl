<div id="informal_formlist">
    <table>
        <tr>
            <th>Formular</th>
        </tr>
{section name=f loop=$forms}
        <tr>
            <td><a href="{$forms[f].url}">{$forms[f].name}</a></td>
        </tr>
{/section}
    </table>
</div>
