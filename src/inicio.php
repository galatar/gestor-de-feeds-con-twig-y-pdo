<?php

$feeds = array(
    "http://galatar.com/feed/",
    "http://ellatidodelucifer.blogspot.com/feeds/posts/default",
    "https://www.reddit.com/r/programming/.rss"
);
$reserva = array(
    "https://www.elblogsalmon.com/index.xml",
    "http://maxburstein.com/rss",
    "http://www.engadget.com/rss.xml",
    "http://www.reddit.com/r/programming/.rss"
);

//Read each feed's items
$entradas = array();
foreach ($feeds as $feed) {
    $xml = simplexml_load_file($feed);
    $entradas = array_merge($entradas, $xml->xpath("//item"));
    //$entradas = array_merge($entradas, $xml->xpath("//entry"));
}

//Sort feed entradas by pubDate
usort($entradas, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

$twig->display('inicio.html.twig', array('entradas' => $entradas));
