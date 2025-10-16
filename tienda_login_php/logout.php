<?php
session_start();
session_unset();   // borra todas las variables de sesión
session_destroy(); // destruye la sesión
header("Location: login.php");
exit;
