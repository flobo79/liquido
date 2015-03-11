<form action="{$action_link}" method="post">
<p>
Are you sure to drop the database and all its contents?<br /><br />
<input type="hidden" name="db_id" value="{$id}" />
<input type="submit" value="Yes" name="confirmed" class="submitButton" />
<input type="submit" value="Cancel" name="cancelled" class="submitButton" />
</form>
