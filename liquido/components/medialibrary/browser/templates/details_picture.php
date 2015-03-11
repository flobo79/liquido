
<img src="<?php echo $data['mime'] == 'picture' ? (MEDIALIB.'/'.$data['id'].'/small.jpg') : '/liquido/components/medialibrary/gfx/file.gif'; ?>" />

<div class="meta">
	<strong><?php echo $data['name'] ?></strong>
	<div class="bu_select" id="bu_select">Datei auswählen</div>
</div>
