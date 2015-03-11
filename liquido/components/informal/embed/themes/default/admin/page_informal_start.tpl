<h2>Welcome to the informal headquarter</h2>
<p>
Access a public submission form by clicking on its name. If you are the
administrator of a database, click the "Admin" link next to the database
name.<br /><br />
{section name=d loop=$databases}
+ <a href="{$databases[d].link}">{$databases[d].name}</a> [<a href="{$databases[d].admin_link}">Admin</a>]<br />
{/section}
</p>
<p>
<a href="{$informal_admin_link}">Informal Administrator Login</a>
</p>
