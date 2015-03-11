

<h2>Form submissions</h2>

<div class="formElement">

	<div id="submissions_table">
	
	{section name=s loop=$submissions}
	
	
	
	
	{/section}
	<table width="400">
	  <tr>
		<th>#</th>
		<th>Date</th>
	{section name=h loop=$submissions}
		<th>{$submissions[h].name}</th>
	{/section}
	  </tr>
	{section name=r loop=$submissions}
	  <tr>
		<td>$submissions[r].number</td>
		<td>$submissions[r].date</td>
		{section name=v loop=$rows[r].values}
		<td>{$section}</td>
		{/section}
	  </tr>
	{/section}
	</table>
	
	</div>

</div>
