<?php


	$auth_noredirect = true;
	include("connector.php");
	
	$sl->setFolder($_GET['page']);
   	
echo "<smil>
	<head>
		<meta name=\"title\" content=\"Example SMIL playlist for the JW Player\"/>
	</head>
	<body>
		<seq>
	";
	
	foreach($sl->childs as $item) {
    
	echo "<par>
		<anchor href=\"http://www.vw-club.de\" />
 		";
		
		
	switch($item['mime']) {
  	case "flv":
		echo "
			<video title=\"FLV video\" src=\"http://www.vw-club.de/liquido_medialib/".$item['id']."/".$item['id'].".flv\" author=\"\" alt=\".\"/>
			";
 	 	break;
		
  		case "picture":
			echo "
			<img title=\"FLV video\" src=\"http://www.vw-club.de/liquido_medialib/".$item['id']."/large.jpg\" author=\"\" alt=\".\"/>
			<anchor href=\"http://www.bigbuckbunny.org/\"/>
			";
 	 		break;
		case "mp3":
			echo "
			<audio title=\"FLV video\" src=\"http://www.vw-club.de/liquido_medialib/".$item['id']."/".$item['id'].".mp3\" author=\"\" alt=\".\"/>
			<img src=\"files/bunny.jpg\"/>
			<anchor href=\"/\"/>
			";
			break;
		} 
	echo "
    </par>
	";
	}
echo "		</seq>
	</body>
</smil>
";

 
?>