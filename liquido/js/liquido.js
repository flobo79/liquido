var L = false;
var Liquido = new Class({
	api:'/liquido/lib/api.php',
	
	/**
	* Main interface function to call methods from the server.
	* If you supply the method name, it will call a method from the Joel class
	* If you supply a method name in this format "classname:methodname" the method will
	* be called in the given class name.
	* 
	* @param {String} method method to be called
	* @param {Object} parameter parameter to be passed to method
	* @param {Function} onComplete function to be called after response from server
	* @param {String} update id of dom tree element to be updated with response from server
	* @param {Bool} async async set "true" to process ajax request ansynchronously
	* @param {Bool} evalReturn async set "true" to evaluate javascript contained in response
	*/
	
	request:function(method, parameter, onComplete, update, async, evalReturn) {
		var packet = {'parameter':parameter}
		var path = method.split(":");
		
		packet['query'] = method;
		
		var query = {
			url:this.api,
			method: 'post',
			data:'json='+JSON.encode(packet)
		};
		
		if(typeof async != "undefined") query.async = async;
		if($type(update) == 'element') query.update = update;
		if($defined(evalReturn)) query.evalScripts = true;
		
		query.onFailure = function (res) { 
			//BC.broadcastMessage('L.request.error', res); 
		}
		
		query.onComplete = function (res, text) {
			var regex = new RegExp("^error:*");
			
			if(res == 'logout') {
				//document.location.href='?logout=1';
			
			} else if (regex.exec(res)) {
				//BC.broadcastMessage('L.request.error',res);
				
			} else {
				if($type(onComplete) == 'function') {
					onComplete(res,text);
				}
			}
		}
		
		// fire!
		new Request(query).send();
	},
	
	saved:function () {
		if(!$('img_saved')) new Element('div',{id:'img_saved'}).inject(document.body,'top');
		$('img_saved').set('tween','long');
		$('img_saved').setStyles({display:'block',opacity:1});
		top.setTimeout(function() { $('img_saved').tween('opacity',0)},1000);
	},
	
	clean_url:function (str) {
	   return str_replace(
	   	['Ö', 'Ä', 'Ü', 'ö', 'ä', 'ü',' ','ß','é','&'],
		['oe', 'ae', 'ue', 'oe', 'ae', 'ue','-','ss','e','und'],
		str).toLowerCase();
	}
	
});

document.addEvent('domready', function() {
	L = new Liquido();
	// add pointer to all divs with onclick action
	$$('div,img').each(function(e) { if(typeof e.onclick === 'function') { e.style.cursor='pointer'; }});
});




function is_array(value)
{
   var s = typeof value;
   if (s === 'object')
   {
      if (value)
      {
         if (value instanceof Array)
         {
            s = 'array';
         }
      }
      else
      {
         s = 'null';
      }
   }
   return s;
}

function str_replace(search, replace, subject)
{
   subject = {subject:subject};
   
   if (is_array(search) == 'array' ) {
	  search.each(function(e,i) {
	  	this.subject = this.subject.split(e).join(replace[i]);
	  },subject);
	  
   } else {
      subject.subject = subject.subject.split(search).join(replace);
   }
   
   return subject.subject;
}




function option(id) { return new getObj(elementname); }

// nimmt den focus von einem link
function unfocus(tar){ if(tar.blur); tar.blur();} 


function part(id,focusfield,img,chgimgto) {
	
	var obj = $(id);
	if(obj.style.display == 'none' || obj.style.display == '' ) {
		obj.style.display='block';
		//if($(focusfield)) $(focusfield).focus();
	} else {
		obj.style.display='none';
	}
	
	if(chgimgto) {
		var imgobj = $(img);
		if(images[img] != undefined) {
			oldsrc = imgobj.src;
			$(img).src = images[img];
			images[img] = oldsrc;
		} else {
			images[img] = imgobj.src;
			$(img).src = chgimgto;
		}
	}
}


function ConfirmAction(text, afterEvent) {
	if(confirm(text)) {
		afterEvent();
	} else {
		return false;
	}
}

/* findet ein Objekt anhand der id */
function getObj(id) {
	return $(id);
}

function openLibrary (id, parameter) {
	//var width = document.getElementById('objectdata['+id+'][tnwidth]').value;
	window.open('compose/medialibrary/index.php','library','width=500,height=340,resizable=yes');
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n]; 
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function show(elementname){
	if (typeof elementname == 'string') {
		$(elementname).style.display = 'block';
	} else {
		elementname.style.display = 'block';
	}
}

function hide(elementname){
	$(elementname).style.display='none';
}

function hideAllNavi() {
	$$('.subnavi').each(function(e) {
		e.style.display="none";
	});
}

function nofunct() {}
