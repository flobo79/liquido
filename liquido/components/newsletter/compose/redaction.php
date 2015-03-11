<script language="javascript" type="text/javascript" src="compose/scripts.js"></script>
<script language="JavaScript" type="text/JavaScript" src="/liquido/components/medialibrary/browser/mediabrowser.js"></script>
<script  language="javascript" type="text/javascript" >
	var pageid = '<?php echo $pageid; ?>';
	var mySortables = [];
	var selected = false;
	var block = 'node-<?php echo $pageid; ?>';
	var compose = true;
	var contentwidth = 500;
	
	document.addEvent('domready', function() {
		/**  add click events to boxes */
		
		$('node-<?php echo $pageid ?>').addEvent('mousedown', selectBox);
		var contentdim = $('contents').getCoordinates();
		contentwidth = contentdim.width;

		/** rename all field names to a more transparent style */
		renameFields();
		
		$$('.compose_imgbox img').each(function (el) {
			el.onclick = function () { imageDetails(el.id.substr(3)); }
			/***  BETAAAA   Resize Images by just 
			el.makeResizable({
				modifiers: {x: false, y: "height"},
				limit: {y: [50]}}	
			);
			*/
		});
		
		/** add events to images **/
		$$('.compose_imgbox').each(function(e) {
			var id = e.id.substr(e.id.lastIndexOf('_')+1);
			e.addEvents({
				mouseenter:function() {
					$('delpic'+id).setStyles({opacity:0, display:'block'}).fade('in');
				},
				mouseleave:function() {
					$('delpic'+id).fade('out');
				}
			});
			
			var obj = e.getParent('.objbox');
			var te = obj.getElement('textarea');
			var ib = obj.getElement('.imgbox');
			
			if(te && ib) {
				var ibdim = ib.getCoordinates();
				te.setStyle('width',(contentwidth - ibdim.width - 7)+'px');
			}
		});
		
		/** Make Objects Sortable **/
		mySortables = new Sortables('#'+block, {
			handle:'.sort',
			constrain:true,
			opacity:.5,
			onComplete:function (	) {
				L.request('newsletter:compose:updateOrder',{'order': (mySortables.serialize(1, function(e, i) {
					return id = e.id.substr(3);
				})).join(',')});
			}
		});
	});
	
	window.addEvent('load',function() {
		/** create a mediabrowser ...  */
		mediabrowser = new Mediabrowser();
		
		/** ... and setup mediabrowsers callbacks */
		mediabrowser.select = insertImage; 
		
	});
	
	function renameFields() {
		// rename all content object input field names
		$$('input,select,textarea').each(function(e) {
			if(e.name.indexOf('[') != -1) {
				e.name = e.name.substring(e.name.lastIndexOf('[')+1, e.name.lastIndexOf(']'));
			}
		});
	}
	
	function imageDetails(id) {
		var coord = $('img'+id).getPosition();
		
		imgDetails = new Modal({width:550, padding:10, height:500});
		imgDetails.div.style.top = coord.xpos+'px';
		imgDetails.div.style.height='auto';
		imgDetails.div.innerHTML = '<div style="padding:30px;"><div class="spinner">Lade Bildeigenschaften...</div></div>';
		setTimeout(function() {
			L.request('contents:compose:imgDetails',{id:id}, function(html) {
				
				imgDetails.div.innerHTML = html;
			});
		},300);
	}
	
	function insertImage(id) {
		mediabrowser.close();
		
		var request = {};
		request['image'] = id;
		request['obj'] = selected.id;
		
		$$('#'+selected.id+' select, #'+selected.id+' input').each(function(el) {
			this[el.name] = el.value;
		},request);
		
		L.request('newsletter:compose:insertImage',request,function(r) {
			if(!r) return;
			var r = JSON.decode(r);
			var obj_id = selected.id.substr(3);
			var pos = 'left';
			var width = 200;
			var margin = 0;
			
			var obj_textarea = selected.getElement('textarea[name=text]');
			
			var img = new Element('div',{
				id:'compose_imgbox_'+r.id,
				'class':'compose_imgbox',
				styles:{
					'float':pos,
					opacity:0,
					marginRight:'0px'
				},
				html:['<img src="',r.link,'?',(new Date().getTime()),'" id="img',r.id,'" /><div id="delpic',r.id,'" class="delbutton" onclick="delPic(',obj_id,')"></div>'].join('')
			});
				
			var dim = $('contents').getCoordinates();
			
			
			if (obj_textarea) {
				obj_textarea.style.width = (dim.width - margin - width - 5) + 'px';
			}
			var img = img.inject($('imgbox'+obj_id));
			var id = r.id;
				
			img.addEvent('mouseenter',function() {
				$('delpic'+id).setStyles({opacity:0, display:'block'}).fade('in');
			});
			img.addEvent('mouseleave',function() {
				$('delpic'+id).fade('out');
			});
			$('img'+r.id).addEvent('click',function() {
				imageDetails(id);
			});
			$('delpic'+id).addEvent('click',function() {
				delpic(id);
			});
			img.fade('in');
		});
	}
	
	function updateImage() {
		var params = {};
		var str = $('form_imgdetails').toQueryString().split('&').each(function(e) {
			var set = e.split('=');
			this[set[0]] = set[1];
		},params);
		
		if (typeof params.margin == 'undefined') params.margin = 1;
		var id = $('imgid').value;
		var dim = $('contents').getCoordinates();
		var txwidth = Number(dim.width) - Number(params.margin) - Number(params.width) - 5;
		
		var div_imagebox = $('imgbox'+params['cid']);
		if(params['pos'] == 'left') {
			div_imagebox.setStyles({
				'float':'left',
				marginRight:params['margin']+'px',
				marginLeft:0
			});
			
		} else {
			div_imagebox.setStyles({
				'float':'right',
				marginRight:0,
				marginLeft:params['margin']+'px'
			});
		}
		
		L.request('newsletter:compose:updateImage',params,function(res) {
			var img = new Fx.Morph('img'+params['id'], {duration: 'short', transition: Fx.Transitions.Sine.easeInOut});
			img.start({
			    'width': params['width']
			}).chain(function () { $('img'+id).src=$('img'+id).src+'?'+(new Date().getTime()); });
			
			if($('text'+params['cid'])) {
				var tx = new Fx.Morph($('text'+params['cid']), {duration: 'short', transition: Fx.Transitions.Sine.easeInOut});
				tx.start({
				    'width': txwidth
				});
			}
		});
	}

	
	function delpic(id) {
		L.request('newsletter:compose:del_pic',{picid:id},function() { });
		var imgbox = selected.getElement('.imgbox');
		
		$('compose_imgbox_'+id).set('tween').tween('opacity',0);
		setTimeout(function() {
			$('compose_imgbox_'+id).dispose();
				
			var dim = $('contents').getCoordinates();
			var dim_imgbox = imgbox.getCoordinates();
			
			var obj_textarea = selected.getElement('textarea[name=text]');
			if (obj_textarea) {
				obj_textarea.setStyles({
					width: (dim.width - dim_imgbox.width - 5) + 'px'
				});
			}
		
		},500);
	}
	
	/** inserts object into page */
	function insert(type, obj) {
		var request = {};
		request['type'] = type;
		request['obj'] = obj;
		
		L.request('newsletter:compose:insertObject',request,function(response) {
			var result = JSON.decode(response);
			var el = new Element('div',{
				id:'obj'+result.id,
				'class':'objbox',
				styles:{opacity:0},
				html:result.html});
			
			if(selected) {
				var newel = el.inject(selected,'after');
			} else {
				var newel = el.inject($(block),'bottom');
			}
			
			newel.fade('in');
			mySortables.addItems(newel);
			mySortables.fireEvent('onComplete');
			renameFields();
		});
	}
	
	function savex() {
		var obj = {}
		var list = $$('#'+block+' .objbox').each(function(el) {
			var foo = {};
			el.getElements('input,textarea,select').each(function(i) {
				this[i.name] = escape(encodeURIComponent(i.value));
			},foo);
			this[el.id] = foo;
		},obj);
		
		L.request('newsletter:compose:update', {'data':obj, parent:pageid },function() {
			L.saved();
		});
	}
	
	function del (id) {
		if('obj'+id === selected.id) selected = false;
		$('obj'+id).fade('out').get('tween').chain(function () { this.element.dispose(); });
		L.request('newsletter:compose:delObj', {'id':id});
	}

	
	function selectBox (ev) {
		if(selected) {
			selected.removeClass('selected');
		}
	
		var el = ev.target;
		while(!el.hasClass('objbox')) {
			el = el.getParent();
		}
		
		el.addClass('selected');
		selected = el;
	}
	

	styles = new Array();
	<?php $i=1; foreach($styles as $key => $style) { echo "styles['".$style['title']."'] = $i;\n"; $i++; } ?>
	
	
</script>
<div id="composeoptions" class="hidden" onClick="MM_dragLayer('composeoptions','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',true,'')" style=" z-index:1; position:absolute" >
	<img src="<?php echo LIQUIDO ?>/gfx/less.gif" onclick="saveSettings()" title="Fenster schliessen" alt="x" style="float:right; margin:2px; cursor:pointer;" />
	Bildposition: <input type="radio" name="pos" id="setpos_left" value="left" />links | <input id="setpos_right" type="radio" name="pos" value="right" />rechts<br>
	Textabstand: <input type="text" name="ta" id="setta" value="" /><br>
	Schriftstil: <?php echo $css_styles ?><br>
	<a href="#" onclick="selectImage(); return false">&raquo; Bild hinzufügen</a><br>
	<br>
</div>

<?php 
	
	$contents = $node->listobjects();

	// hole template
	if($nlobj['template'] and $thiscomp['loadtemplate']) {
		$template = getTemplate($nlobj['template']);
		$parser = new Parser();
		$parser->html = $template[0];
		echo $parser->parse();
	}
?>

<form action="body.php" method="post" enctype="multipart/form-data" name="page" id="contents">

	<?php if($thiscomp['loadtemplate'] and !$nlobj['template']) { include("hint_notemplate.php"); } ?>
	<?php if($contents != "noobjects") {
		 echo $contents;
		} else {
			include("hint_noobjects.php");
		}
	 ?>
	<a name="composebottom"></a>
	
	<?php if($template[1]) {
		$parser->html = $template[1];
		echo $parser->parse();
	} 
	?>
</form>
