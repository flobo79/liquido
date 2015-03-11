<?php

// contents-template
$objecttitle = "Vote Modul";


switch ($part) {
	case "compose":
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");
?>

Frage eingeben:<br />
<textarea style="width:99%" name="content[<?php echo $result['id'] ?>][text]" ><?php echo $result['text']; ?></textarea>
<br />
<br />
Geben Sie hier mehrere mögliche Antworten, getrennt jeweils durch einen Absatz ein:<br/>
<textarea style="width:99%" rows="4" name="content[<?php echo $result['id'] ?>][text2]" ><?php echo $result['text2']; ?></textarea>


<?php 
	break;
	default:
?>

<style type="text/css">
	.vote_select {
		width:44px;
		height:22px;
		float:left; 
	}
	.vote_item {
		float:left;
		width:100%;
	}
</style>

<script type="text/javascript">
	var vote<?php echo $result['id'] ?> = {}

	document.addEvent('domready',function () {
		vote<?php echo $result['id'] ?> = {
			id:<?php echo $result['id']; ?>,
			saveVote:function() {
				// send vote to server
				var value = '';
				var _this = this;
				$(this.id+'_vote_answers').getElements('input[name=a'+this.id+']').each(function(i){
					if (i.checked) {
						value = i.value;
					}
				});
				L.request('module:votemodul:setVote',{vote:value,id:this.id},function(res) {
					var r = JSON.decode(res);
					for(e in r.av) {
						$(_this.id+"_"+e.substr(1)).fade('out');
					};
					$('<?php echo $result['id'] ?>_vote_result').fade('out');
					setTimeout(function() {
						for(e in r.av) {
							$(_this.id+"_"+e.substr(1)).set('html','<div class="bar" style="font-size:0; width:'+(r.av[e])+'%;"><!-- --></div>').fade('in');
						};
						$('<?php echo $result['id'] ?>_vote_result').set('html','Vielen Dank für Ihre Stimmenabgabe.<br />Insgesamt wurde '+r.sum+' abgestimmt.<br>').fade('in');
						
					},250);
					
					Cookie.write('vote<?php echo $result['id'] ?>','1');
				});
			},
			init:function () {
				var mycookie = Cookie.read('vote<?php echo $result['id'] ?>');
				
				$('<?php echo $result['id'] ?>_vote_answers').setStyles({opacity:0,display:'block'});
				$('<?php echo $result['id'] ?>_vote_result').setStyles({opacity:0,display:'block'});
				
				if (mycookie) {
					var _this = this;
					L.request('module:votemodul:getStat',{id:this.id},function(res) {
						var r = JSON.decode(res);
						for(e in r.av) {
							$(_this.id+"_"+e.substr(1)).set('html','<div class="bar" style="font-size:0; width:'+(r.av[e])+'%;"><!-- --></div>');
						};
						$('<?php echo $result['id'] ?>_vote_result').set('html','Sie haben bereits abgestimmt.<br />Stimmen insgesamt: '+r.sum+'.<br>');	
						
					});
				} else {
					$('<?php echo $result['id'] ?>_vote_answers').style.display='block';
					
				}
				$('<?php echo $result['id'] ?>_vote_answers').fade('in');
				$('<?php echo $result['id'] ?>_vote_result').fade('in');
			}
		}

		vote<?php echo $result['id'] ?>.init();
	});
	
</script>

<?php echo nl2br($result['text']); ?>

<div id="<?php echo $result['id'] ?>_vote_answers" style="display:none">
<?php 
$antworten = split("\n", $result['text2']);
foreach($antworten as $k => $a) {
?>
<div class="vote_item">
<div class="vote_answer">
	<div id="<?php echo $result['id'] ?>_<?php echo ($k); ?>" class="vote_select"><input type="radio" name="a<?php echo $result['id'] ?>" id="a<?php echo $result['id'] ?>" value="a<?php echo $k+1 ?>" /></div> <?php echo nl2br($a); ?>	
</div>
</div>
<?php } ?>
</div>
<div id="<?php echo $result['id'] ?>_vote_result" style="display:none;">
	<input type="button" onclick="vote<?php echo $result['id'] ?>.saveVote();" value="absenden" />
</div>

<?php	break;
	}
?>
