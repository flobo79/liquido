

function markSelection (txtObj) {
 if (txtObj.createTextRange ) {
		txtObj.caretPos = document.selection.createRange().duplicate();
		txtField = txtObj;
		isSelected = true;
	}
}


function insertTag ( tag, enclose ) { 
	if(tag != "0") {
	 var closeTag = tag;
	 if ( enclose ) {
	   var attribSplit = tag.indexOf ( ' ' );
	   if ( tag.indexOf ( ' ' ) > -1 )
		 closeTag = tag.substring ( 0, attribSplit );
	 }
	 if ( isSelected && tag) {
	   var Field = txtField.name;
	   var txtObj = eval ( "document.forms[0]." + Field );
	   if (txtObj.createTextRange && txtObj.caretPos) {
		 var caretPos = txtObj.caretPos;
		 caretPos.text = ( ( enclose ) ? "<"+tag+">"+caretPos.text+"</"+closeTag+">" : "<"+tag+">"+caretPos.text );
		 markSelection ( txtObj );
		 if ( txtObj.caretPos.text=='' ) {
		   isSelected=false;
		txtObj.focus();
		 }
	   }
	   
	 } else {
	   // placeholder for loss of focus handler
	 }
	}
}

function Action (txtObj) {
	//alert(txtObj);
	eval(txtObj+"()");
}

function delstrukt() {
	window.location.href='middle.php?delstruct=true';
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