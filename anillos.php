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
    <title>Anillos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container opciones">
    <h1>Anillos</h1>
    <p>Bienvenido a la sección de Anillos. Aquí puedes explorar todos nuestros anillos.</p>

    <div class="grid-opciones">
        <?php
        $anillos = [
            ['nombre' => 'Anillo Minimal', 'imagen' => 'Images/placeholder.png', 'precio' => '10€'],
            ['nombre' => 'Anillo Elegante', 'imagen' => 'Images/placeholder.png', 'precio' => '15€'],
            ['nombre' => 'Anillo Colorido', 'imagen' => 'Images/placeholder.png', 'precio' => '12€']
        ];

        foreach ($anillos as $anillo):
        ?>
            <div class="producto">
                <div class="producto-media">
                    <img src="<?= $anillo['imagen'] ?>" alt="<?= htmlspecialchars($anillo['nombre']) ?>">
                </div>
                <h3><?= htmlspecialchars($anillo['nombre']) ?></h3>
                <span class="precio"><?= $anillo['precio'] ?></span>
                <button class="btn-line">Ver detalle</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
