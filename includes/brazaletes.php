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
    <title>Brazaletes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container opciones">
    <h1>Brazaletes</h1>
    <p>Bienvenido a la sección de Brazaletes. Aquí puedes explorar todos nuestros brazaletes.</p>

    <div class="grid-opciones">
        <?php
        $brazaletes = [
            ['nombre' => 'Brazalete Minimal', 'imagen' => 'Images/placeholder.png', 'precio' => '18€'],
            ['nombre' => 'Brazalete Elegante', 'imagen' => 'Images/placeholder.png', 'precio' => '22€'],
            ['nombre' => 'Brazalete Colorido', 'imagen' => 'Images/placeholder.png', 'precio' => '20€']
        ];

        foreach ($brazaletes as $brazalete):
        ?>
            <div class="producto">
                <div class="producto-media">
                    <img src="<?= $brazalete['imagen'] ?>" alt="<?= htmlspecialchars($brazalete['nombre']) ?>">
                </div>
                <h3><?= htmlspecialchars($brazalete['nombre']) ?></h3>
                <span class="precio"><?= $brazalete['precio'] ?></span>
                <button class="btn-line">Ver detalle</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
