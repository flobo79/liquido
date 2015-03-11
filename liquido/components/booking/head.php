

<?php 

include("lib/init.php");
$access = loadAccessTable($_SESSION['user'],$_SESSION['current']['comp']);

?><ul id="component_areas">
	<?php if($access['c1']) { ?><li><a href="#" onclick="top.content.location.href='components/booking/bookings.php'">Buchungen</a></li><?php } ?>
	<?php if($access['c2']) { ?><li><a href="#" onclick="top.content.location.href='components/booking/dates.php'">Events</a></li><?php } ?>
	<?php if($access['c3']) { ?><li><a href="#" onclick="top.content.location.href='components/booking/places.php'">Venues</a></li><?php } ?>
	<?php if($access['c4']) { ?><li><a href="#" onclick="top.content.location.href='components/booking/types.php'">Eventarten</a></li><?php } ?>
	<?php if($access['c5']) { ?><li><a href="#" onclick="top.content.location.href='components/booking/coupons.php'">Gutscheine</a></li><?php } ?>
	<li><a href="#" onclick="top.content.location.href='components/booking/statistiken.php'">Statistik</a></li>
</ul>