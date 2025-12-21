<?php
require_once "db_connect.php";
// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de control - LARANA JEWELRY</title>
    <link rel="stylesheet" href="css/style.css?v=1">
</head>
<body>

    <main class="container" style="text-align:center; padding:80px 20px;">
        <h1>Muchas gracias, <span style="color:#c6a664;">
            <?= htmlspecialchars($usuario['nombre']) ?>
        </span></h1>
        <p style="margin-top:40px;">
            <a href="logout.php" style="color:#c6a664; text-decoration:none; font-weight:500;">Cerrar sesión</a>
        </p>
        <p style="margin-top:40px;">
            <a href="../index.php" style="color:#c6a664; text-decoration:none; font-weight:500;">Inicio</a>
        </p>
    </main>

</body>
</html>
