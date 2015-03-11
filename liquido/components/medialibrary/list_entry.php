<?php 


$ico = $result['mime'] == 'picture' ? 
	MEDIALIB."/".$result['id']."/thumbnail.jpg" :  
	"gfx/{$result[mime]}.gif";
	
?>
<div class="row" id="e<?php echo $result['id'] ?>" onclick="selectFolder('<?php echo $result['id'] ?>'); con.click(this);" onmouseover="con.over(this);" onmouseout="con.out(this);">
    <div class="icon"><img src="<?php echo $ico; ?>" /></div>
	<div class="label"><?php if($result['id'] == $current) echo "<a name=\"current\"></a>"; echo $result['name']; ?></div> 
</div>
