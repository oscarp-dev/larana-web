<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../tienda_login_php/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Brazaletes</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="producto.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main class="container">
    <h1>Brazaletes</h1>
    <p>Bienvenido a la sección de Brazaletes. Aquí encontrarás todos nuestros brazaletes.</p>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
