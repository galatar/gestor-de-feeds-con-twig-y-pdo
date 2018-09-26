<?php
global $plantilla;
global $datos;

// Comprueba si el formulario viene relleno
if (filter_has_var(INPUT_GET, 'feed')) {
    $feed = filter_input(INPUT_GET, 'feed', FILTER_SANITIZE_STRING);
    $datos['feed'] = $feed;
    // Recupera los artículos del feed
    $xml = simplexml_load_file($feed);
    if (is_object($xml) && $articulos = $xml->xpath("//item")) {
        $datos['articulos'] = $articulos;
    }
    // Comprueba si el feed existe en la base de datos
    $datos['feed_existe'] = false;
    $query = $dbh->prepare('SELECT count(*) FROM feed WHERE url = :feed');
    $query->bindParam(':feed', $feed);
    $query->execute();
    if ($query->fetchColumn()) {
        $datos['feed_existe'] = true;
    }
}

$plantilla = 'mostrar_feed.html.twig';