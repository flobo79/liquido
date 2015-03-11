<table height="99%" width="900" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td height="<?php echo $toolbar['height'] ?>">
			<div id="topmenue" style="height:<?php echo $toolbar['height'] ?>px">
				
				<?php  if(!$toolbar['nosearch']) { ?>
				<div id="searchbox">
					<div id="searchelem"><input name="search" id="search" value="<?php echo $search; ?>" maxlength="25" onkeyup="searchthis(value,'<?php echo $part.".php"; ?>')" /><div id="delsearch" style="display:none"><img src="/liquido/components/booking/gfx/searchdel.gif" alt="suche löschen" onclick="delsearch('<?php echo $icons['list']['file'] ?>')" style="cursor:pointer;" /></div></div>
				</div>
				<?php } ?>
				 <div id="icons">
				   <ul id="iconlist">
						<?php
						$i=1;
						if(is_array($icons)) {
							reset($icons);
							foreach($icons as $thisicon) {
								echo "<li id=\"o".$i."\"".($i == 1 ? " class=\"activeicon\"" : "").">
									<div class=\"icon\" style=\"cursor:pointer\" onclick=\"$thisicon[link] check('o$i'); return false\" >
										<img src=\"/liquido/components/booking/gfx/$thisicon[icon]\" alt=\"$thisicon[icon]\" /><br />
										$thisicon[title]
									</div>
								</li>\n";
								$i++;
							}
						}
						?>
					</ul>
				  </div>
				  <?php if(file_exists("tpl_".$part."_tools.php")) include("tpl_".$part."_tools.php"); ?>
			</div>
		</td>
	</tr>
