<?php
global $dbh;
global $smarty;

if (filter_has_var(INPUT_GET, 'feed')) {
    $feed = filter_input(INPUT_GET, 'feed', FILTER_SANITIZE_URL);
    $query = $dbh->prepare('INSERT INTO feed (url) VALUES (:url)');
    $query->bindParam(':url', $feed);
    $query->execute();
    header('location:index.php?pagina=inicio');
} else {
    header('location: index.php?pagina=agregar_feed');
}
