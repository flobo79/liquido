<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          
    <td valign="top" bgcolor="#F7F7F7">
    </td>
        </tr>
        <tr> 
          <td width="293" valign="top"><p>Name: <?php echo $containerobj['title']; ?><br>
        <span class="smalltext">erstellt: <?php echo getDay($containerobj['date']) ?><br>
              Gr&ouml;sse: <?php echo number_format(filesize(CONTAINERDIR.$temp['id']."/".$containerobj['title']),2,",","."); ?></span></p>

            

		<p>&nbsp; </p></td>
	</tr>
  </table>
