<?php
// debug.php: muestra todo lo que llega desde el formulario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php";
// $_POST contiene los datos enviados por el formulario con method="post"
echo "<h2>Contenido de \$_POST</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

// También puedes ver información completa de la petición
echo "<h2>Contenido de \$_REQUEST</h2>";
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
?>
