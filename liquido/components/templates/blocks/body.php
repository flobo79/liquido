<?php 

include("../../../lib/init.php");

// globals hack
foreach($_GET as $K => $V) { $$K = $V;}
foreach($_POST as $K => $V) { $$K = $V; }
unset($K,$V);

include("functions.inc.php");

$blocks = $db->getArray("select * from ".db_table("blocks")." order by title");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>blocks</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script language="JavaScript" type="text/JavaScript" src="../../../js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../../../js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../functions.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo LIQUIDO ?>/js/liquido.js"></script>
	<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css">
	<link href="styles.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		.section {
			padding:10px;
			margin-top:10px;
		}
		
		#box_list {
			float:left;
			width:250px;
			margin:10px;
		}
		
		#box_details {
			display:none;
			float:left;
			width:250px;
			margin:10px;
		}
		#box_details_details input, #box_details_details textarea {
			width:100%;
		}
		#box_nodes {
			display:none;
			float:left;
			width:300px;
			margin:10px;
		}
	</style>
	<script type="text/javascript">
		var current = false;
		
		loadBlock = function (id) {
			current = id;
			L.request('templates:blocks:loadBlock',{id:id},function(data) {
				fillForm(JSON.decode(data));
			});
			
			$('bu_del').style.display='block';
			$('box_nodes').style.display='block';
			$('box_details').setStyles({opacity:0, display:'block'}).fade('in');
		}
		
		newBlock = function () {
			var block = {
				title:'',
				description:'',
				link:'',
				id:'',
				nodes:[]
			}
			$('box_details').style.display='bock';
			$('box_nodes').style.display='none';
			$('bu_del').style.display='none';
			fillForm(block);
		}
		
		
		fillForm = function (block) {
			for(e in block) {
				if($(e)) $(e).value = block[e];
				$('blocklink').innerHTML = block.link;
			}
			
			var box_nodes = $('box_nodes_list');
			box_nodes.innerHTML = '';
				if(block.nodes.length) {
					block.nodes.each(function(e) {
					new Element('div',{
						id:'e'+e.id,
						html:'<div class="sort"></div><div>'+e.title+'</div>'
					}).inject(box_nodes);
				});
			}
			
			// Apply Sortables to node list
			var mySortables = new Sortables('#box_nodes_list', {
				handle:'.sort_tn',
				constrain:true,
				opacity:.5,
				clone:true,
				onStart:function() {
					this.oldorder = (mySortables.serialize(1,function(element, index) {
				    	return element.id
					}).join(','));
				},
				
				onSort:function () {
					(mySortables.serialize(1, function(e, i) {
						return id = e.id.substr(1);
					}));
				},
				
				onComplete:function (foo) {
					var newIndex = 0;
					var newOrder = (mySortables.serialize(1, function(e, i) {
						return id = e.id.substr(1);
					}));
					
					if(newOrder != this.oldorder) {	
						L.request('templates:blocks:updateOrder',{'id':current, 'order':newOrder.join(',')});
					}
				}
			});
			
			$('box_details').style.display='block';
			
		}

		saveBlock = function() {
			if($('title').value != '') {
				L.request('templates:blocks:saveBlock',{
					id:$('id').value,
					title:$('title').value,
					link:$('blocklink').innerHTML,
					description:$('description').value
				}, function (res) {
					if(Number(res) != 'NaN' && $('id').value == '') {
						$('id').value=res;
						current = res;
						var el = new Element('div', {
							id:'block'+res, 
							html:$('title').value,
							events:{
								click: loadBlock(res)
							},
							styles:{
								cursor:'pointer', 
								opacity:0
							}
						}).inject($('box_list_list'), 'bottom').fade('in');
						
						$('bu_del').fade('in');
					} else {
						$('block'+$('id').value).innerHTML = $('title').value;
					}
				});
				L.saved();
				
			}
		}
		
		delBlock = function () {
			var id=$('id').value;
			if(confirm('Möchten Sie den Block wirklich löschen?\n\nAchtung: Alle Zuweisungen gehen verloren!!')) {
				L.request('templates:blocks:delBlock',{id:id},function (res) {
					$('box_details').fade('out');
					$('box_nodes').fade('out');
					$('block'+id).dispose();
				});
			}
		}
	</script>
</head>
<body>
<div id="inner">
	<div id="box_help" class="section">
		Blöcke sind Bildschirmbereiche, in denen Inhalte gesammelt angezeigt werden können.
		<div onclick="$('help_more').show(); this.hide();">mehr...</div>
	
	<div id="help_more" style="display:none">
			Sie können einem Block Inhalte hinzufügen, indem Sie eine oder mehrere neue oder vorhandene Seiten einem Block zuordnen. Gehen Sie dazu in die Seiten-Eigenschaften und öffnen Sie die Kategorie "Blöcke".
			Anschliessend fügen Sie den gewünschten Block in ein Template oder in eine Seite ein, indem Sie <block:(Block-Id)/> einfügen.
		Blöcke sind immer vorlagenübergreifend, das heisst, wenn Sie einen Block erstellen, können sie diesen in jedem Template und jeder Seite einfügen.</div>
	</div>
	<div id="box_blocks" class="section">
		<div id="box_list">
			<h3>Vorhandene Blöcke:</h3>
			<div id="box_list_list">
			<?php foreach($blocks as $b) {
				echo "<div onclick=\"loadBlock($b[id]);\" id=\"block$b[id]\" >".$b['title']."</div>";
			}
			?>
			</div>
			<br>
			<div onclick="newBlock();">Neuen Block erstellen</div>
		</div>
		
		<div id="box_details">
			<div id="box_details_details">
				<h3>Block Details:</h3>
				<h4>Title*:</h4>
				<input type="text" name="title" id="title" value="" onkeyup="$('blocklink').innerHTML=L.clean_url(this.value);"/><br>
				<br>
				Link:<br>
				&lt;block:<span id="blocklink"></span>&gt;<br>
				<span class="smalltext">maschinenlesbarer Link ohne Leerzeichen und Sonderzeichen<br></span>
				<br>
				 Beschreibung:<br>
				 <textarea name="description" id="description"></textarea><br>
				 <br>
			</div>
			<input type="hidden" id="id" name="id" value=""  />
			<input type="button" onclick="saveBlock();" value="Speichern" style="float:left;"/>
			<input type ="button" id="bu_del" style="float:left;" onclick="delBlock();" value="Block löschen" />
		</div>
		
		<div id="box_nodes">
			<h3>Block Nodes:</h3>
			Nodes (Seiten) die diesem Block zugeordnet sind:<br>
			<div id="box_nodes_list" class="sort_list" style="width:100%;">
				
			</div>
			<br>
			<span class="smalltext">Tip: Ordnen Sie die Reihenfolge an indem Sie die Elemente durch drag&drop verschieben.</span>
		</div>
	</div>
</div>
</body>
</html>