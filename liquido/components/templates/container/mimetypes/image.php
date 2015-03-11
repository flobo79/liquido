<?php
// bildrösse
$size = GetImageSize($_SERVER['DOCUMENT_ROOT'].CONTAINERDIR."$temp/$containerobj[title]");



?> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          
    <td valign="top" bgcolor="#F7F7F7"> <img src="<?php echo CONTAINERDIR.$temp ?>/<?php echo $containerobj['title'] ?>" hspace="3" vspace="10"> 
    </td>
        </tr>
        <tr> 
          <td width="293" valign="top"><p>Name: <?php echo $containerobj['title']; ?><br>
        <span class="smalltext">erstellt: <?php echo getDay($containerobj['date']) ?><br>
              Gr&ouml;sse: <?php echo "$size[0]x$size[1] px"; ?></span></p>

            

            <p>&nbsp; </p></td>
        </tr>
      </table>