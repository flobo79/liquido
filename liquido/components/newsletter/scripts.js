function comboaction (action, form) {
	if(checkSelection()) {
		if(action == 'delete') {
			ConfirmAction('Die gewählten Abonnenten wirklich löschen?', function() { $('aboform').submit(); });	
		} else {
			$('aboform').submit();
		}
	} else {
		alert('bitten wählen Sie mindestens 1 Eintrag aus');
	}
}

function checkSelection () {
	temp = document.form1.elements.length ;
	for (var i = 1; i < temp; ++i) {
	  if(document.forms[0].elements[i].type == "checkbox" && document.forms[0].elements[i].checked==true) return true;
	}
	return false;
}

function selectall () {
	Invers();
}

function Invers() {
	temp = document.form1.elements.length;
	for (i=0; i < temp; i++) {
		if(document.form1.elements[i].checked == 1) {
			document.form1.elements[i].checked = 0;
		} else {
			document.form1.elements[i].checked = 1
		}
	}
}