	<?php $pageid = $data['id']; ?>
	<script type="text/javascript">
		var pageid = '<?php echo $pageid; ?>';
		var mySortables = [];
		var selected = false;
		var block = 'node-<?php echo $pageid; ?>';
		var compose = true;
		var contentobjects = [];	// list of objects on the page
		
		document.addEvent('domready', function() {
		    //var noPNGSupport = (document.body.filters) ? true : false;
			//if (noPNGSupport) new pngFix();

			// setup right hand column accordion
			var myAccordion = new Accordion($$('.acc_toggle'), $$('.acc_content'));
			var contentdim = $('contents').getCoordinates();
			contentwidth = contentdim.width;
			
			/**  add click events to boxes */
			$('node-<?php echo $pageid ?>').addEvent('mousedown', selectBox);
			
			/** rename all field names to a more transparent style */
			renameFields();
			
			// add image details popup to all images
			$$('.compose_imgbox img').each(function (el) {
				el.onclick = function () { imageDetails(el.id.substr(3)); }
				/***  BETAAAA   Resize Images by 
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
//					te.setStyle('width', (contentwidth - ibdim.width - 10)+'px');
				}
			});
			
			/** Make Objects Sortable **/
			mySortables = new Sortables('#'+block, {
				handle:'.sort',
				constrain:true,
				opacity:.5,
				onComplete:function (	) {
					L.request('contents:compose:updateOrder',{'order': (mySortables.serialize(1, function(e, i) {
						return id = e.id.substr(3);
					})).join(',')});
				}
			});


			// find css select boxen and add some magic to them
			$$('.css_box').addEvent('change', function() {
				var select = this;
				var classname = this.value.substr(1);
				select.getParents('div.objbox').getElements('textarea').each(function(e) { e.set('class','').addClass(classname); });
			});
		});
 		
		// load mediabrowser after all files - including the mediabrowser file - have been loaded
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
			L.request('contents:compose:imgDetails',{id:id}, function(html) {
				imgDetails.div.innerHTML = html;
			});
		}
		
		function insertImage(id) {
			mediabrowser.close();
			
			var request = {};
			request['image'] = id;
			request['obj'] = selected.id;
			
			$$('#'+selected.id+' select, #'+selected.id+' input').each(function(el) {
				this[el.name] = el.value;
			},request);
			
			L.request('contents:compose:insertImage',request,function(r) {
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
					html:'<img src="'+r.link+'" id="img'+r.id+'" /><div id="delpic'+r.id+'" class="delbutton" onclick="delpic('+obj_id+')"></div>'
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
			
			showPublishButton();
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
			
			L.request('contents:compose:updateImage',params,function(res) {
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
			
			showPublishButton();
		}

		
		function delpic(id) {
			L.request('contents:compose:del_pic',{picid:id},function() { });
			var imgbox = selected.getElement('.imgbox');
			showPublishButton();
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
			
			L.request('contents:compose:insertObject',request,function(response) {
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
				
				showPublishButton();
			});
		}
		
		function savex() {
			var obj = {}
			
			var list = $$('#'+block+' .objbox').each(function(el) {
				var foo = {};
				el.getElements('input,textarea,select').each(function(i) {
					if(i.type == 'checkbox') {
						this[i.name] = i.checked ? escape(encodeURIComponent(i.value)) : '';
					} else if (i.type == 'radio') {
						this[i.name] = escape(encodeURIComponent($$('#'+i.id+":selected").value));
					} else {
						this[i.name] = escape(encodeURIComponent(i.value));
					}
				},foo);
				
				this[el.id] = foo;
			},obj);

			L.request('contents:compose:update', {'data':obj, parent:pageid },function() {
				contentobjects.each(function(e) {
					if(typeof e.save == 'function') {
						e.save();
					}
				});

				L.saved();
				showPublishButton();
			});
		}

		


		
		function del (id) {
			if('obj'+id === selected.id) selected = false;
			$('obj'+id).fade('out').get('tween').chain(function () { this.element.dispose(); });
			L.request('contents:compose:delObj', {'id':id});
			
			showPublishButton();
		}
		
		function showPublishButton() {
			$('topbox_publish').style.display = 'block';
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
		
	</script>
<style type="text/css"> 
	#pagecontent { 
		left:0;
		position:absolute;
		right:180px;
	}
</style>
<div id="pagecontent" >
	<form action="body.php" method="post" enctype="multipart/form-data" name="page" style="width:100%">
	<div id="topbox">
			<div id="topbox_publish" style="display:<?php echo $node->cache['refresh'] == "6" ? 'block' : 'none'; ?>" onclick="document.location.href='?refresh=<?php echo $pageid; ?>';">
			  Änderungen <br />veröffentlichen
			</div>
		  
		<?php echo $data['title']; ?><br />
		<span class="smalltext">ID: <?php echo $data['id'] ?> - <?php showstatus($data['status']) ?></span>
	</div>

    <div id="contents" style="width:<?php echo $data['width'] ?>px;">
		<?php 
			echo $node->listobjects(); 
		?> 
		<a name="composebottom"></a>
	</div>
	
	<input name="objectdata[objects]" type="hidden" value="<? echo $objects; ?>" />
	<input name="update" type="hidden" value="true" />
	<input name="objectdata[id]" type="hidden" value="<?php echo $data['id'] ?>" />
</form>
</div>




<div id="toolbar">
  <table width="165" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr>
      <td height="21" background="gfx/right_pane_top-v3.gif">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" background="gfx/right_pane_content-v3.gif">
      		<br>
			<div style="text-align:left; margin-left:21px;">
              <?php listTools($thiscomp);  ?>
              <br> <br>
        
              <a href="javascript:savex();" onMouseOver="MM_swapImage('save','','gfx/compose_save_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="gfx/compose_save.gif" name="save"></a><br>
             <br>
          </div>
		  </td>
    </tr>
    <tr> 
      <td><img src="gfx/right_pane_bottom-v3.gif" width="165" height="31"></td>
    </tr>
  </table>
 </div>