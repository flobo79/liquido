<script language="javascript">
function Invers(){ldelim}
temp = document.{$formname}.elements.length ;
for (i=0; i < temp; i++){ldelim}
	if(document.{$formname}.elements[i].checked == 1) {ldelim}
		document.{$formname}.elements[i].checked = 0;
	{rdelim} else {ldelim}
		document.{$formname}.elements[i].checked = 1{rdelim}
	{rdelim}
{rdelim}
</script>
