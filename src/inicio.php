<?php
global $twig;

$feeds = array(
    "https://www.tomasvotruba.cz/rss",
    "http://galatar.com/feed/",
    "https://www.killerphp.com/articles/feed/",
);

$articulos = array();
foreach ($feeds as $feed) {
    $xml = simplexml_load_file($feed);
    $articulos = array_merge($articulos, $xml->xpath("//item"));
}
//Ordena las articulos por fecha de publicación
usort($articulos, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

try {
    $twig->display('inicio.html.twig', array('articulos' => $articulos));
} catch (Twig_Error_Loader $e) {
    var_dump($e);
} catch (Twig_Error_Runtime $e) {
    var_dump($e);
} catch (Twig_Error_Syntax $e) {
    var_dump($e);
}
