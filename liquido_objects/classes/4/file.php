<?php


// contents-template
$objecttitle = "PHP Feld";
$thisobject['formrows'] = "5";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth - $size[0] - $result['text2'];

$code = str_replace(array("exec","eval","system"),"/* forbidden code */",$result['text']);

if($fmode) $part = "public";

if($part == "compose") {
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");

?>

<textarea name="objectdata[<?php echo $result['id']; ?>][text]" rows="50" wrap="OFF" class="text" style="width:100%"><?php echo $result['text']; ?></textarea>
                 
<?php } else {
	eval($result['text']);
}?>