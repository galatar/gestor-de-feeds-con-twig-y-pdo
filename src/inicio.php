<?php
global $plantilla;
global $datos;
global $dbh;

//$feeds = array(
//    "https://gonzalo123.com/feed/",
//    "https://www.htmlgoodies.com/rss.xml",
//);
//$reserva = array(
//    "https://news.ycombinator.com/rss",
//    "https://www.tomasvotruba.cz/rss",
//    "http://galatar.com/feed/",
//    "https://www.killerphp.com/articles/feed/",
//    "https://www.hitsubscribe.com/blog/feed/",
//    "https://jesuslc.com/blog/feed/",
//    "http://feeds.feedburner.com/desarrolloweb/novedades-articulos",
//    "https://blog.phpdeveloper.org/feed/",
//    "https://frontendfoc.us/rss/",
//    "https://www.dreamhost.com/blog/feed/",
//    "http://ellatidodelucifer.blogspot.com/atom.xml",
//);

$query = $dbh->prepare('SELECT * FROM feed WHERE favorito = 1;');
$query->setFetchMode(PDO::FETCH_ASSOC);
$query->execute();
$entradas = array();
while ($feed = $query->fetch()) {
    $xml = simplexml_load_file($feed['url']);
    if (is_object($xml)) {
        $entradas = array_merge($entradas, $xml->xpath("//item"));
    }
}
//Ordena las entradas por fecha de publicación
usort($entradas, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

$plantilla = 'inicio.html.twig';
$datos = array('entradas' => $entradas);
