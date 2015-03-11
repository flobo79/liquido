<?php $areadata = getareadata($thiscomp['area']);  ?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="40"><img src="gfx/page.gif" border="0"></td>
    <td> Bereich <b><?php echo $areadata['area']['title']; ?></b> <br>
		von Ausgabe:<b><a href="?select[id]=<?php echo $nlobj['id'] ?>"><?php echo $nlobj['title'] ?></a></b><br>
    </td>
    <td width="162" align="right"> 
      <?php if($update) echo "<img src=\"gfx/fade.gif\" border=\"0\">" ?>
    </td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	<form action="body.php" method="post" enctype="multipart/form-data" name="page" target="middle">
		<table width="<?php echo $nlobj['groupwidth'] ?>" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
				<?php 

				$thisobj = $thiscomp['area'];
				$objects = listobjects($thiscomp['area'],"area"); ?>
					  
				<input name="objectdata[objects]" type="hidden" value="<? echo $objects; ?>">
				<input name="update" type="hidden" value="true">
				<a name="composebottom"></a>
			</td>
		  </tr>
		</table>
	</form>
	</td>
  </tr>
</table>

