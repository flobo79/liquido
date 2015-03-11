<?php


// contents-template

$objecttitle = "Datei-download";


switch ($part) {
	case 'compose': 
		$object_head_right = "<div class=\"bu_add\" onclick=\"mb{$result[id]}.open();\"></div>";
		include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");

?> 

<script type="text/javascript">
	medialib = '<?=MEDIALIB ?>';
	var mb = false;
	document.addEvent('domready', function() {
		mb<?=$result['id'] ?> = new Mediabrowser({type:'file'});
		mb<?=$result['id'] ?>.select = function(id, data) {
			$('objectdata[<?=$result['id'] ?>][text3]').value=data.name;
			$('objectdata[<?=$result['id'] ?>][text2]').value=data.id;
			
			$('link<?=$result['id'] ?>').href= medialib+'/'+data.id+'/'+data.name;
			$('link<?=$result['id'] ?>').innerHTML=data.name;
		};
	}); 
</script>

<label for="objectdata[<? echo $result['id']; ?>][text]">Link Bezeichnung:</label>
<input name="objectdata[<?=$result['id'] ?>][text]" type="text" value="<?php echo $result['text'] ?>" style="width: 40%">
<span class="smalltext" id="filename<?=$result['id'] ?>">
	<a href="<?php echo MEDIALIB.'/'.$result['text2'].'/'.$result['text3'] ?>" id="link<?=$result['id'] ?>"><?=$result['text3'] ?></a>
</span>

<input type="hidden" value="<?=$result['text2']?>" id="objectdata[<? echo $result['id']; ?>][text2]" name="objectdata[<? echo $result['id']; ?>][text2]" />
<input type="hidden" value="<?=$result['text3']?>" id="objectdata[<? echo $result['id']; ?>][text3]" name="objectdata[<? echo $result['id']; ?>][text3]" />

<?php	break;
	case 'public':
		$dir = MEDIALIB.'/'.$result['text2'];
		if(file_exists($docdir = $_SERVER['DOCUMENT_ROOT'].$dir)) {
			$d = dir($docdir);
			while($entry=$d->read()) {
				if($entry !="." and $entry != "..") {
					
					echo "<a href=\"".$dir."/$entry\" class=\"download\" target=\"_blank\">$result[text]</a>";
					break;
				}
			}
		}
		
		break;
}
?>

	