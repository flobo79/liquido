<?php

// contents-template
$objecttitle = "send2friend";

$id = $result['id'];
switch ($part) {
	case "compose":
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");
?>
<b>Link Text (zB: Seite empfehlen):</b><input type="text" name="content[<?php echo $result['id'] ?>][text2]" value="<?php echo $result['text2']; ?>" />
<br><br><b>Info Text:</b><br />
<textarea style="width:99%" name="content[<?php echo $result['id'] ?>][text]" ><?php echo $result['text']; ?></textarea>
<br />
<b>Email Text Body:</b><br />
<textarea rows="5" style="width:99%" name="content[<?php echo $result['id'] ?>][text3]" ><?php echo $result['text3'] ? $result['text3'] : "Hallo,

_name_ hat Ihnen folgende Webseite weiterempfohlen:
_link_.

und folgende Nachricht hinterlassen:
_nachricht_

Ihr Volkswagen Club"; ?></textarea><br>
<br />

<?php 
	break;
	default:
?>
<style type="text/css">

</style>

<script type="text/javascript">
	var send2friend<?php echo $id ?> = {
		id:<?php echo $id; ?>,
		send:function() {
			if(!utils.isEmail($('s2f<?php echo $id ?>email').value)) { alert('Bitte eine gültige Emailaddresse angeben.'); }
			else {
				var _this = this;
				$('s2fopener<?php echo $id ?>').onclick = function() {};
				L.request(
					'module:send2friend:send',
					{
						to:$('s2f<?php echo $id ?>email').value,
						id:<?php echo $id; ?>,
						name:$('s2f<?php echo $id ?>name').value,
						message:$('s2f<?php echo $id ?>message').value,
						page:'<?php echo "http://".$_SERVER['HTTP_HOST']."/".$_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>'
					},
					function(res) { if (res) { 	alert(res) 	} else { 
						$('s2fbox<?php echo $id ?>').fade('out');
						setTimeout(function() {
							$('s2fbox<?php echo $id ?>').setStyles({display:'none'});
							$('s2fbox<?php echo $id ?>').getElements('input[type=text],textarea').set('value','');
							$('s2f<?php echo $id ?>_result').setStyles({opacity:0,display:'block'}).fade('in');
							top.setTimeout(function() {
								$('s2f<?php echo $id ?>_result').fade('out').get('tween');
								top.setTimeout(function() {
									$('s2fopener<?php echo $id ?>').onclick = _this.open;
								},501);
							},2500);
						},501);
					}}
				);
			}
		},
		open:function() { $('s2fbox<?php echo $id ?>').setStyles({opacity:0,display:'block'}).fade('in'); },
		close:function() { $('s2fbox<?php echo $id ?>').fade('out'); }
	}
</script>

<div class="s2fopener" id="s2fopener<?php echo $id ?>" onclick="send2friend<?php echo $id ?>.open();"><?php echo ($result['text2']); ?></div>
<div id="s2fbox<?php echo $id ?>" style="display:none;">
	<?php echo nl2br($result['text']); ?>
	<br />
	Ihr Name:<br />
	<input type="text" id="s2f<?php echo $id ?>name" style="width:200px;" value="<?php echo "<xclass:34> <xclass:35>"; ?>"/><br />
	E-Mail Adresse des Empfängers:<br />
	<input type="text" id="s2f<?php echo $id ?>email" style="width:200px;" /><br />
	Ihre Nachricht:<br />
	<textarea id="s2f<?php echo $id ?>message" style="width:200px;" rows="4" /></textarea><br />
	<input type="button" onclick="send2friend<?php echo $id ?>.send();" value="absenden" /> <input onclick="send2friend<?php echo $id ?>.close();" type="button" value="abbrechen" /> 
</div>
<div id="s2f<?php echo $id ?>_result" style="display:none" >Vielen Dank.</div>
<?php	break;
	}
	
unset($id);
?>
