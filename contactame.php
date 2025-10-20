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
    <title>Contáctame</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main class="container">
    <h1>Contáctame</h1>
    <p>Si quieres ponerte en contacto con nosotros, rellena el formulario o escríbenos a nuestro correo.</p>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
