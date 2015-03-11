// JavaScript Document

if(typeof MooTools == "undefined") {
	 
	/*
	var mootools = document.createElement('script');
	var script = document.createElement('script');
	 	script.src = "/liquido/js/mootools.js";
		script.type = "text/javascript";
		script.id = "mikosScript";
	
	var head = document.getElementsByTagName('head');
	head[0].appendChild(script);
	*/
}


/**
 * Loader to wait to load the mootools class
 * and append it to the dom
 * 
 * @author florian bosselmann <flobo@ultradigital.de>
 */
window.addEvent('domready', function() {
	
	// move all floatings whereever they are into the body tag
	$$('.floating').each(function(floating) {	
		floating.dispose().injectInside('body');
	});
	
	
	// find all submit buttons and turn the parent forms into ajax forms
	$$('input.submit').each(function(button) {
		
		// find parent form...
		var parentform = button.getParent();
		while(parentform && parentform.tagName.toLowerCase() != 'form') {
			parentform = parentform.getParent(); 
		}
		
		
		var newSubmitButton = new Element('input');
		newSubmitButton.setAttribute('type', 'submit');
		newSubmitButton.setAttribute('class', 'submit');
		newSubmitButton.setAttribute('name', button.name);
		newSubmitButton.setAttribute('value', button.value);
		newSubmitButton.setAttribute('id', button.id);
		
		newSubmitButton.replaces(button);
		
		
		
		
		// ... and apply ajax functionality
		parentform.addEvent('submit', function(e) {
			e.stop();
			button.disabled = true;
			
			if($('output')) { 
				$('output').empty().removeClass('response_error').addClass('ajax_wait').innerHTML='Sende Daten...';
			}
			$$('.redBorder').removeClass('redBorder').removeClass('.tip');
			
			// apply ajax actions to submit event
			this.set('send', {
				evalScripts:true,
				onComplete:function() {
					if($('output')) { 
						$('output').removeClass('ajax_wait'); 
					}
					button.disabled = false;
				}
			});
			//Send the form.
			this.send();
		});
	});
	
	if (typeof mikos != 'undefined' && $type(mikos) == 'string') {
		if($type(this[mikos]) == "function") this[mikos]();
	}
	
	updateTips();
});
	
/**
* 	apply tool tips to every element with class name .tip
*
*/
function updateTips() {
	/*
	//store titles and text
	$$('.tip').each(function(element,index) {
		var content = element.get('title').split(':');
		element.store('tip:title', content[0]);
		element.store('tip:text', content[1]);
	});
	
	console.log('update tups');
	//create the tooltips
	var tipz = new Tips('.tip',{
		className: 'tip',
		fixed: true,
		hideDelay: 50,
		showDelay: 50,
		'show': function(tip) {
			tip.fade('in');
		},
		'hide': function(tip) {
			tip.fade('out');
		}
	});
	*/
}


function getScrollXY(dim) {
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }

	if(dim == 'x') {
		return (scrOfX);
	} else if (dim == 'y') {
		return (scrOfY);
	} else {
		return [ scrOfX, scrOfY ];
	}
}

function getWindowSize(dim) {
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
	if(dim == 'x') {
		return (myWidth);
	} else if (dim == 'y') {
		return (myHeight);
	} else {
		return [myWidth, myHeight];
	}
}

function getWindowCenter(dim) {
	var winsize = getWindowSize();
	var scroll = getScrollXY();
	
	if(dim == 'x') {
		return (((winsize[0])/2)+scroll[0]);
	} else if (dim == 'y') {
		return (((winsize[1])/2)+scroll[1])
	} else {
		return [(((winsize[0])/2)+scroll[0]), (((winsize[1])/2)+scroll[1])];
	}
}

function iecompattest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}


/****  MIKOS related functions ****/
function myDataInit() {
	$('bu_edit').onclick = function () {
		$('edit_window').style.marginTop=getScrollXY('y')+30+'px';
		$('Edit').style.display='block';	
	}
	
	$('bu_cancel').onclick = function () {
		// reset
		for (e in jsobj) {
			$(e).value = jsobj[e];
		}
		$('Edit').style.display='none';
	}
}


function myCars() {
	if($('addCar')) {
		$('addCar').onclick = function () {
			$('editCar').style.display = 'block';
			$('edit_loading').style.display='none';
			$('edit_content').style.display='block';
			$('edit_window').style.marginTop=getScrollXY('y')+30+'px';
			$('form_editMyCars').reset();
			$('class').value = 'KIS';
			$('kis_action').value='doCreateCar';
			$('submit_form').value='Hinzufügen';
			$('bu_cancel').value = 'Abbrechen';
			$('output').innerHTML = '';
			$('carEditTitle').innerHTML = 'Fahrzeug hinzufügen';
			
			$('editCar').style.display='block';
		}
	}
	$('bu_cancel').onclick = function() {
		$('editCar').style.display='none';
		$('form_editMyCars').reset();
		$('class').value = 'KIS';
		$('output').innerHTML = '';
		$$('.redBorder').each(function(e) { e.empty().removeClass('redBorder'); });
	}
	
	myCarsApplyActions();
}

function myCarsApplyActions() {
	$$('.icon_delete').each(function(e) {
		e.onclick=function () { 
			if(confirm('Dieses Fahrzeug löschen?')) { 
				request({ 'class':'KIS','kis_action':'doDeleteCar','id':this.id });
			}
		}
	});
	$$('.icon_edit').each(function(e) {
		e.onclick=function () {
			$('carEditTitle').innerHTML = 'Fahrzeug editieren';
			$('bu_cancel').value = 'Schliessen';
			$('kis_action').value='doEditCar';
			$('class').value = 'KIS';
			$('edit_loading').style.display='block';
			$('edit_content').style.display='none';
			$('edit_window').style.marginTop=getScrollXY('y')+30+'px';
			$('editCar').style.display='block';
			request({ 'class':'KIS','kis_action':'ajax_loadMyCarDetails','id':this.id });
		}
	});
}


function myEmployees() {
	if($type($('addEmployee')) == 'element') {
	 
		$('addEmployee').onclick = function () {

			var fieldlist = "fronttitle,firstname,surname,pasttitle,phone,email,fax,mobile,username,password,password2,secretQuestion,secretAnswer,gender,status";
			fieldlist = fieldlist.split(",");
			
			for(i=0;e=fieldlist[i];i++) {
				if (e == 'gender') {
					$('gender_'+0).checked = true;
				} else if (e == 'status') {
					$('d_status').selectedIndex = 0;
				} else {
					$('d_'+e).value='';
				}
			}
			
			$('bu_delete').style.display='none';
			$('cpis_action').value='doCreateEmployee';
			$('editEmployeeContent').style.marginTop=getScrollXY('y')+30+'px';
			$('bu_submit').value='Anlegen';
			$('edit_headline').innerHTML = 'Mitarbeiter anlegen';
			$('editEmployee').style.display = 'block';
		}
	}
	
	if($type($('bu_delete')) == 'element') {
		$('bu_delete').onclick = function () {
			if(confirm('Diesen Mitarbeiten löschen?')) {
				request({ 'class':'CPIS','cpis_action':'doDeleteEmployee','id':$('ID').value });
			}	
		}
	}
	
	$('bu_cancel').onclick = function () {
		$('editEmployee').style.display = 'none';
		$('output').empty();
		$$('.redBorder').each(function(e) { e.empty().removeClass('redBorder'); });
	}

	myEmployeesApplyActions();
}

function myEmployeesApplyActions() {
	$$('.showEmployee').each(function(e) {
		e.onclick=function () {
		
			var id = this.id.substring(1);
            
			//$('edit_loading').style.display='block';
			$('edit_content').style.display='block';
			$('edit_headline').innerHTML = 'Mitarbeiter bearbeiten';
			if($type($('bu_submit')) == 'element') { $('bu_submit').value = 'Speichern'; }
		    
			$('cpis_action').value='doEditEmployee';
			$('editEmployeeContent').style.marginTop=getScrollXY('y')+30+'px';
			
			
			// fill in fields
			var thisemp = myEmployeesList['employee'+id];
			
			for(e in thisemp) {
				if(e == 'password') {
					//$('d_password').value=thisemp[e];
					//$('d_password2').value=thisemp[e];
				} else if (e == 'gender') {
					if(thisemp[e] == '') thisemp[e] = '0';
					$('gender_'+thisemp['gender']).checked = true;
				} else if (e == 'status') {
				       if(thisemp['status'] < 0) thisemp['status']=0;
					if(thisemp['status'] > 3) thisemp['status']=3;
					$('d_status').selectedIndex = thisemp['status'];
				} else {
					$('d_'+e).value = thisemp[e];
				}
			}
			
			$('editEmployee').style.display='block';
			
			if($type($('bu_delete')) == 'element') {
				$('bu_delete').style.display='none';
			}
		}
	});
}


function myMemberListApplyActions() {
	$$('.showMember').each(function(e) {
		e.onclick=function () {
			var id = this.id.substring(1);

			// fill in fields
			var thisemp = myMemberList['member'+id];
			
			for(e in thisemp) {
					$('d_'+e).value = thisemp[e];
			}

			$('cpis_action').value='doEditMemberData';
			$('editMemberContent').style.marginTop=getScrollXY('y')+30+'px';
			            
			//$('edit_loading').style.display='block';
			$('edit_content').style.display='block';
			$('edit_headline').innerHTML = 'Mitglied bearbeiten';
			if($type($('bu_submit')) == 'element') { $('bu_submit').value = 'Speichern'; }
			
						
			$('editMember').style.display='block';
			
			if($type($('bu_delete')) == 'element') {
				$('bu_delete').style.display='none';
			}

			//if($type($('bu_cancel')) == 'element') {
			 $('bu_cancel').onclick = function () { $('editMember').style.display='none'; }
			//}
			
		}
	});
	
}

function myDealerInit() {
	$$('.showDetails').each(function(e) {
		e.onclick=function() {
			document.status='click';
			var id = this.id.substring(1);
			var dealer = myDealer['dealer'+id];
			
			for(thisitem in dealer) {
				
				$('e_'+thisitem).innerHTML = dealer[thisitem];
				if(thisitem == 'email') $('e_'+thisitem).innerHTML = '<a href="mailto:'+dealer[thisitem]+'">'+dealer[thisitem]+'</a>';
				if(thisitem == 'webSite') $('e_'+thisitem).innerHTML = '<a href="'+dealer[thisitem]+'" target="_blank">'+dealer[thisitem]+'</a>';
			}

			$('details_content').style.marginTop=getWindowCenter('y')-100+'px';
			$('details').style.display='block';
		}
	});
	
	$('bu_cancel').onclick = function () { $('details').style.display='none'; }
}


function myMember() {
	$('addMember').onclick = function () {
		$('cpis_action').value='doCreateMember';
		$('form_editMember').style.marginTop=getScrollXY('y')+30+'px';
		$('editMember').style.display='block';
		$('submit_form').value='Einmelden';
	}

	$('bu_cancel').onclick = function () {
		$('editMember').style.display='none';
		$$('.redBorder').removeClass('redBorder');
		$$('input').each(function(e,i) { if(e.type == 'text' || e.type=='password') { e.value=""; }});
		$('output').empty();
	}

	myMemberApplyActions();
}

/**
* Applies interactivity to MyMember Interface
*
*/
function myMemberApplyActions() {
	
}

function paMyDataInit () {
	$('bu_edit').onclick = function () {
		$('Edit').style.display='block';
		$('edit_window').style.marginTop=getScrollXY('y')+30+'px';
	}
	$('bu_cancel').onclick = function () {
		$('output').innerHTML = '';
		for(e in mydatastr) {
		  if($(e)) {
		      $(e).value = mydatastr[e];
		  }
		}
		$('Edit').style.display='none';
	}
}



/** 
 * function to make a request to the server
 *
 * @param {Object} obj Object containing data to deliver to server
 * @param {Object} update Dom handle to place the return message in
 */
var mikos_request = false;
function request (obj,update) {
	var params = {
		method: 'post',
		evalScripts:(update ? false : true),
		data:obj
	}
	
	// if update field is given, update this field with response
	if($(update)) { params.update = $(update); }
	
	// cancel possibly existing mikos requests
	if(mikos_request) { mikos_request.cancel(); }
	
	mikos_request = new Request({
	    url: '/mikos/libs/ajax.php',
	    method: 'post',
		evalScripts:(update ? false : true),
		data:obj,
		onComplete:function(res) {
			if($('output')) { 
				$('output').innerHTML = '';
				$('output').removeClass('ajax_wait'); 
			}
		},
		onFailure:function(res) {
			if($('output')) { 
				$('output').removeClass('ajax_wait').addClass('response_error').innerHTML = 'Fehler: '+res;
			}
		}
	}).send();
}
