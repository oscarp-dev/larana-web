<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: tienda_login_php/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pulseras</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="productos/producto.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container">
    <h1>Pulseras</h1>
    <p>Bienvenido a la sección de Pulseras. Aquí puedes explorar todas nuestras pulseras.</p>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
