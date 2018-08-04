<?php
global $twig;

$feeds = array(
    "http://galatar.com/feed/",
    "https://www.killerphp.com/articles/feed/",
    "https://www.hitsubscribe.com/blog/feed/",
    "https://news.ycombinator.com/rss",
    "https://jesuslc.com/blog/feed/",
    "http://feeds.feedburner.com/desarrolloweb/novedades-articulos",
    "https://blog.phpdeveloper.org/feed/",
    "https://frontendfoc.us/rss/",
);
$reserva = array(
    "http://ellatidodelucifer.blogspot.com/atom.xml",
);

$entradas = array();
foreach ($feeds as $feed) {
    $xml = simplexml_load_file($feed);
    $entradas = array_merge($entradas, $xml->xpath("//item"));
//    $entradas = array_merge($entradas, $xml->xpath("//item/pubdate[text() = '2018']"));
}
//Ordena las entradas por fecha de publicación
usort($entradas, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

try {
    $twig->display('inicio.html.twig', array('entradas' => $entradas));
} catch (Twig_Error_Loader $e) {
} catch (Twig_Error_Runtime $e) {
} catch (Twig_Error_Syntax $e) {
}
