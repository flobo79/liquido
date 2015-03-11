<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$LIQUIDO}/css/liquido.css" rel="stylesheet" type="text/css">
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="/liquido/js/mootools.js"></script>
<script language="JavaScript" type="text/JavaScript" src="/liquido/js/utils.js"></script>
<script language="JavaScript" type="text/JavaScript" src="/liquido/js/liquido.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
	{if $update_leftframe} //parent.left.location.href = 'left_pane.php?noupdate=1';{/if}
//-->

{literal}
	
	var sortChilds = false;
	var pageId = '{/literal}{$data.id}{literal}';
	
	checkSyslinkAndSave = function() {
		if($('link').value != '') { 
			// check cleanURL first
			L.request('contents:detail:checkSyslink',{syslink:$('link').value, id:pageId },function(res) {
				if(res != '') {
					
					var list = JSON.decode(res);
					
					var pages = '';
					list.each(function(e) {
						pages += '  '+e.title+' (id: '+e.id+')\n';
					});
					
					alert('Diese Clean URL wird bereits von folgender Seite verwendet:\n'+pages);
				} else {
					save();
				}
			});
		} else {
			save();
		}
	};
	
	function save() {
		var rq = {};
		var title = '';
		
		$('eigenschaften').getElements('input, textarea, select').each(function(e) {
			if(e.type == "checkbox") {
				this[e.name] = e.checked ? e.value : "";
			} else {
				this[e.name] = encodeURIComponent(e.value);
				if(e.name == 'title') title = title;
			}
		},rq);
		
		L.request('contents:detail:update',rq,function(r) {
			L.saved();
			if(r == 'reload') {
				$('page_title').innerHTML = title;
				window.location = window.location;
			}
		});	
	}
		
	document.addEvent('domready', function() {

		sortChilds = new Sortables('.childlist-list tbody', {
			handle:'.sort',
			opacity:.5,
			
			onStart:function() {
				this.oldorder = (sortChilds.serialize(1,function(element, index) {
			    	return element.id
				}).join(','));
			},
			
			onSort:function () {
				(sortChilds.serialize(1, function(e, i) {
					return id = e.id.substr(4);
				}));
			},
			
			onComplete:function (foo) {
				var newIndex = 0;
				var newOrder = (sortChilds.serialize(1, function(e, i) {
					return id = e.id.substr(4);
				}));
				
				if(newOrder != this.oldorder) {	
					L.request('contents:detail:updateOrder',{'order':newOrder.join(',')});
				}
			}
		});
		
		$$('#box_blocks_list > li').addEvent('click',function(e) {
			
			contained = false;
			current = this.id.substr(5);
			
			$$('#box_blocks_list li').removeClass('selected');
			this.addClass('selected');
			var box_nodes = $('box_blocks_nodes');
			box_nodes.empty();
			
			L.request('contents:detail:loadBlock',{id:current },function (r) {
				var block = JSON.decode(r);
				
				// list all contents
				block.nodes.each(function(n){
					
					if(n.id == pageid) contained = true;
					new Element('div', {
						id:'n'+n.id,
						html:'<div class="sort small"> </div> '+n.title,
						events:{'click':function() { 
								//alert(this.id);
							}
						}
					}).inject(box_nodes);
				});
				
				setupNodeSettings();
				
				
				
				// Apply Sorting  to node list
				sortBlockNodes = new Sortables('#box_blocks_nodes', {
					handle:'.sort',
					constrain:true,
					opacity:.5,
					//clone:true,
					
					onStart:function() {
						this.oldorder = (sortBlockNodes.serialize(1,function(element, index) {
					    	return element.id
						}).join(','));
					},
					
					onSort:function () {
						(sortBlockNodes.serialize(1, function(e, i) {
							return id = e.id.substr(1);
						}));
					},
					
					onComplete:function (foo) {
						var newIndex = 0;
						var newOrder = (sortBlockNodes.serialize(1, function(e, i) {
							return id = e.id.substr(1);
						}));
						
						if(newOrder != this.oldorder) {	
							L.request('contents:detail:blockNodesUpdateOrder',{'id':current, 'order':newOrder.join(',')});
						}
					}
				});
			});
		});
	});

	{/literal} 
	var pageid = '{$data.id}'; 
	var pagetitle = '{$data.title}'; 
	{literal}
				
		var contained = false; // if page is contained in selected block
		var current = false; // id of currently selected block
		var sortBlockNodes = false; // sortables object
		
		function setupNodeSettings() {
			$$('#box_blocks_settings>div').each(function(e) { e.style.display='none'; });
			if(contained) {
				$('settings_contained').style.display='block';
			} else {
				$('settings_not_contained').style.display='block';
			}
		}
		
		function blockAddNode() {
			L.request('contents:detail:blockAddNode',{id:current,node:pageid });
			
			new Element('div', {
				id:'n'+pageid,
				html:'<div class="sort small"> </div> '+pagetitle,
				events:{'click':function() { 
						//alert(this.id);
					}
				}
			}).inject('box_blocks_nodes');
			
			contained = true;
			setupNodeSettings();
			sortBlockNodes.attach();
		}
		
		function blockRemoveNode() {
			L.request('contents:detail:blockRemoveNode',{id:current,node:pageid });
			$('n'+pageid).dispose();
			contained = false;
			setupNodeSettings();
			sortBlockNodes.attach();	
		}

</script>
<style type="text/css">
	#box_blocks_list { width:150px; }
	#box_blocks_list li { list-style:none; padding:0; margin:0; cursor:pointer; }
	#box_blocks_list { padding:0; margin:0; }	
	#box_blocks_nodes { width:200px; }
	#box_blocks_settings {  width:230px; }
	#box_blocks_list .selected { color:#333; font-weight:bold; }
			
</style>

{/literal}
</head>
<body>
<div id="img_saved"></div>