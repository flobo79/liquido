
<div class="padding">
<table border="1">

<tr>
{if $show_line_numbering eq "yes"}
<th>#</th>
{/if}
{if $show_actions eq "yes"}
<th>Actions</th>
{/if}
{if $show_timestamp eq "yes"}
<th><a href="{$th_time_link}">Time</a></th>
{/if}
{section name=f loop=$formfields}
<th><a href="{$formfields[f].link}">{$formfields[f].name}</a></th>
{/section}
</tr>

{section name=s loop=$submissions}
<tr>
{if $show_line_numbering eq "yes"}
<td align="right">{$submissions[s].number}</td>
{/if}
{if $show_actions eq "yes"}
<td><a href="{$submissions[s].link_view}">View</a> <a href="{$submissions[s].link_edit}">Edit</a> <a href="{$submissions[s].link_del}">Del</a></td>
{/if}
{if $show_timestamp eq "yes"}
<td>{$submissions[s].timestamp}</td>
{/if}
{section name=f loop=$submissions[s].fields}
<td><a href="{$submissions[s].fields[f].link}" class="linkBlind">{$submissions[s].fields[f].name}</a></td>
{/section}
</tr>
{/section}

</table>
</div>

