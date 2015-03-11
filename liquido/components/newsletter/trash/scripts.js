 function recycle() {
	document.form1.type.value = 'rec';
	document.form1.submit();
 }
 
 function del() {
	if(confirm('Die ausgewählten Objekte wirlich löschen?')) {
		document.form1.type.value = 'del';
		document.form1.submit();
	}
 }