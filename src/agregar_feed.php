<?php
global $plantilla;
global $datos;

if (filter_has_var(INPUT_POST, 'feed')) {
    $feed = filter_input(INPUT_POST, 'feed', FILTER_SANITIZE_STRING);
    $datos['feed'] = $feed;
    $xml = simplexml_load_file($feed);
    if (is_object($xml) && $entradas = $xml->xpath("//item")) {
        $datos['entradas'] = $entradas;
    }
}

$plantilla = 'agregar_feed.html.twig';
