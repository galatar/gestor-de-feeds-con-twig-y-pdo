<?php
/* /public/index.php */

// Llama al fichero de autocarga de clases generado por composer
require_once '../vendor/autoload.php';
// Llama al fichero con las constantes definidas para la aplicación
// Este fichero no debe subirse al gestor de versiones
require_once '../config.php';

// La plantilla (template) y los datos se definirán en el controlador secundario cuando toque
$plantilla = "";
$datos = array();
$errores = array();


// Configura la librería Twig
$twig_loader = new Twig_Loader_Filesystem(FEED_TWIG_RUTA_PLANTILLAS);
$twig = new Twig_Environment($twig_loader, array(
  'cache' => FEED_TWIG_RUTA_CACHE,
  'debug' => FEED_DEBUG)
);

// Conecta base de datos con PDO
try {
    // dsn: data source name
    $dsn = FEED_DB_DRIVER. ':host=' . FEED_DB_HOST . ';dbname=' . FEED_DB_NAME;
    // dbh: database handler
    $dbh = new PDO($dsn, FEED_DB_USER, FEED_DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    $error= $e->getMessage();
}

// Captura pagina para enrutado
if (filter_has_var(INPUT_GET, 'pagina')) {
    $pagina = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_URL);
} else {
    $pagina = 'inicio';
}
// Llama al fichero php indicado en la ruta
$ruta_pagina = '../src/' . $pagina . '.php';
if (is_file($ruta_pagina)){
    require_once($ruta_pagina);
} else {
    require_once('../src/error_404.php');
}

// Muestra la plantilla con los datos que vienen del controlador secundario
try {
    $twig->display($plantilla, $datos);
} catch (Twig_Error_Loader $e) {
    $error = $e->getMessage();
} catch (Twig_Error_Runtime $e) {
    $error = $e->getMessage();
} catch (Twig_Error_Syntax $e) {
    $error = $e->getMessage();
}

// Muestra errores si los hay
if ($error) {
    echo '<div class="alert alert-danger">Ha ocurrido un error. Contacte con el responsable del sistema.</div>';
    if (FEED_DEBUG) {
        // Muestra el contenido del error si estamos en modo debug
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
}
