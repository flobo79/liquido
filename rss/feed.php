<?php

$auth_noredirect = true;
include(dirname(dirname(__FILE__))."/liquido/lib/init.php");

$list = $db->getArray("select * from ".db_table('contents')." where `promoteAsRSS` != 0 order by `promoteAsRSS` LIMIT 20");

include("feedcreator.class.php");

$rss = new UniversalFeedCreator();
//$rss->useCached();
$rss->title = "Volkswagen Club";
$rss->description = "Aktuelles vom Club";
$rss->link = "http://www.vw-club.de";
$rss->syndicationURL = "http://www.vw-club.de/".$PHP_SELF;

$image = new FeedImage();
$image->title = "Volskwagen Club GmbH";
$image->url = "http://www.vw-club.de/images/logo.gif";
$image->link = "http://www.vw-club.de";
$image->description = "Feed bereitgestellt von Volkswagen Club GmbH.";
$rss->image = $image;

// get your news items from somewhere, e.g. your database:

foreach($list as $data) {
    $item = new FeedItem();
    $item->title = $data['title'];
    $item->link = "http://www.vw-club.de/".($data['cleanURL'] ? $data['cleanURL'] : $data['title']);
    $item->description = $data['info'];
    $item->date = intval($data['promoteAsRSS']);
    $item->source = "http://www.vw-club.de";
    $item->author = "";
    
    $rss->addItem($item);
}


echo $rss->createFeed("RSS1.0", "news/feed.xml");

?> 
