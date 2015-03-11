<form action="{$action_url}" method="post">
<p>
Database name<br />
<input type="text" size="70" name="form_name" value="{$form_name}" maxlength="255" />
</p>
<p>
Send e-mail notification on new submission<br />
<input type="radio" name="form_email" value="Y"{$form_email_y_checked} /> Yes<br />
<input type="radio" name="form_email" value="N"{$form_email_n_checked} /> No
</p>
<p>
E-mail address for new submission notifications<br />
<input type="text" size="30" name="form_email_address" value="{$form_email_address}" maxlength="255" />
</p>
<p>
Submit button label<br />
<input type="text" size="30" name="form_submit_label" value="{$form_submit_label}" maxlength="255" />
</p>
<p>
"Thank you" message<br />
<input type="text" size="70" name="thank_you_message" value="{$thank_you_message}" maxlength="255" />
</p>
<p>
"Thank you" URL<br />
<input type="text" size="70" name="thank_you_url" value="{$thank_you_url}" maxlength="255" />
</p>
<p>
<input type="hidden" name="id" value="{$id}" />
<input type="submit" value="Update Settings" class="submitButton" />
</p>
</form>
