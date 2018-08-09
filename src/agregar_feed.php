<?php
global $twig;

$variables = array();
if (filter_has_var(INPUT_POST, 'feed')) {
    $feed = filter_input(INPUT_POST, 'feed', FILTER_SANITIZE_STRING);
    $variables['feed'] = $feed;
    $xml = simplexml_load_file($feed);
    if ($entradas = $xml->xpath("//item")) {
        $variables['entradas'] = $entradas;
    }
}

try {
    $twig->display('agregar_feed.html.twig', $variables);
} catch (Twig_Error_Loader $e) {
    var_dump($e);
} catch (Twig_Error_Runtime $e) {
    var_dump($e);
} catch (Twig_Error_Syntax $e) {
    var_dump($e);
}
