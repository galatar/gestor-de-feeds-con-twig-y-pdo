<?php
global $plantilla;
global $datos;

if (filter_has_var(INPUT_GET, 'feed')) {
    $feed = filter_input(INPUT_GET, 'feed', FILTER_SANITIZE_STRING);
    $datos['feed'] = $feed;
    $xml = simplexml_load_file($feed);
    if (is_object($xml) && $articulos = $xml->xpath("//item")) {
        $datos['articulos'] = $articulos;
    }
    $query = $dbh->prepare('SELECT * FROM feed WHERE url = :feed');
    $query->bindParam(':feed', $feed);
    $query->execute();
}

$plantilla = 'mostrar_feed.html.twig';