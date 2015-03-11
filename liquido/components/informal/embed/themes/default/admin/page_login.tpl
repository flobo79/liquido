<form action="{$action_link}" method="post">
<p>
You need to be logged in to access this page.<br /><br />
User name:<br />
<input type="text" size="10" name="username" /><br />
Password:<br />
<input type="password" size="10" name="password" /><br />
<br />
<input type="hidden" name="referer" value="{$referer}" />
<input type="hidden" name="redirect" value="{$redirect}" />
<input type="submit" value="OK" name="confirmed" class="submitButton" />
<input type="submit" value="Cancel" name="cancel" class="submitButton" />
</p>
</form>
