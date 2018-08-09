<?php
global $twig;

try {
    $twig->display('error_404.html.twig');
} catch (Twig_Error_Loader $e) {
} catch (Twig_Error_Runtime $e) {
} catch (Twig_Error_Syntax $e) {
}