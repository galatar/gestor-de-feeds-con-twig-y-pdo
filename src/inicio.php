<?php
global $twig;

$feeds = array(
    "https://gonzalo123.com/feed/",
);
$reserva = array(
    "https://news.ycombinator.com/rss",
    "https://www.tomasvotruba.cz/rss",
    "http://galatar.com/feed/",
    "https://www.killerphp.com/articles/feed/",
    "https://www.hitsubscribe.com/blog/feed/",
    "https://jesuslc.com/blog/feed/",
    "http://feeds.feedburner.com/desarrolloweb/novedades-articulos",
    "https://blog.phpdeveloper.org/feed/",
    "https://frontendfoc.us/rss/",
    "https://www.dreamhost.com/blog/feed/",
    "http://ellatidodelucifer.blogspot.com/atom.xml",
);

$entradas = array();
foreach ($feeds as $feed) {
    $xml = simplexml_load_file($feed);
    $entradas = array_merge($entradas, $xml->xpath("//item"));
}
//Ordena las entradas por fecha de publicación
usort($entradas, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

try {
    $twig->display('inicio.html.twig', array('entradas' => $entradas));
} catch (Twig_Error_Loader $e) {
    var_dump($e);
} catch (Twig_Error_Runtime $e) {
    var_dump($e);
} catch (Twig_Error_Syntax $e) {
    var_dump($e);
}
