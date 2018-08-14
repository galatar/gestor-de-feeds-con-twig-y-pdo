<?php
global $plantilla;
global $datos;
global $dbh;


//$reserva = array(
//    "https://blog.phpdeveloper.org/feed/",
//    "https://frontendfoc.us/rss/",
//    "https://www.dreamhost.com/blog/feed/",
//    "http://ellatidodelucifer.blogspot.com/atom.xml",
//);

$query = $dbh->prepare('SELECT * FROM feed;');
$query->setFetchMode(PDO::FETCH_ASSOC);
$query->execute();
$feeds = array();
$entradas = array();
while ($feed = $query->fetch()) {
    $feeds[] = $feed;
    if ($feed['favorito']) {
        $xml = simplexml_load_file($feed['url']);
        if (is_object($xml)) {
            $entradas = array_merge($entradas, $xml->xpath("//item"));
        }
    }
}
//Ordena las entradas por fecha de publicación
usort($entradas, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

$plantilla = 'inicio.html.twig';
$datos = array('feeds' => $feeds, 'entradas' => $entradas);
