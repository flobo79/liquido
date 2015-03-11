<h2>Create a new database</h2>
<form action="{$action_url_create}" method="post">
<p>
Database name<br />
<input type="text" name="db_name" size="40" />
<br /><br />
Users allowed to admin this database (UIDs separated by comma)<br />
<input type="text" name="db_uid" size="40" />
<br /><br />
Database notification e-mail address<br />
<input type="text" name="email" size="40" />
<br /><br />
<input type="submit" value="Create database" class="submitButton" />
</p>
</form>
<h2>Drop a database</h2>
<form action="{$action_url_drop}" method="post">
<p>
Warning: All data in the database will be lost!<br /><br />
Database: 
<select name="db_id">
<option></option>
{section name=db loop=$databases}
<option value="{$databases[db].id}">{$databases[db].name}</option>
{/section}
</select>
<br /><br />
<input type="submit" value="Drop database" class="submitButton" />
</p>
</form>
