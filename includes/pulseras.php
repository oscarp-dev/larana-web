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
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container opciones">
    <h1>Pulseras</h1>
    <p>Bienvenido a la sección de Pulseras. Aquí puedes explorar todas nuestras pulseras.</p>

    <div class="grid-opciones">
        <?php
        // Array de pulseras de ejemplo
        $pulseras = [
            ['nombre' => 'Pulsera Minimal', 'imagen' => 'Images/placeholder.png', 'precio' => '15€'],
            ['nombre' => 'Pulsera Elegante', 'imagen' => 'Images/placeholder.png', 'precio' => '20€'],
            ['nombre' => 'Pulsera Colorida', 'imagen' => 'Images/placeholder.png', 'precio' => '18€'],
            ['nombre' => 'Pulsera Clásica', 'imagen' => 'Images/placeholder.png', 'precio' => '22€'],
            ['nombre' => 'Pulsera Moderna', 'imagen' => 'Images/placeholder.png', 'precio' => '19€'],
            ['nombre' => 'Pulsera Vintage', 'imagen' => 'Images/placeholder.png', 'precio' => '25€']
        ];

        foreach ($pulseras as $pulsera):
        ?>
            <div class="producto">
                <div class="producto-media">
                    <img src="<?= $pulsera['imagen'] ?>" alt="<?= htmlspecialchars($pulsera['nombre']) ?>">
                </div>
                <h3><?= htmlspecialchars($pulsera['nombre']) ?></h3>
                <span class="precio"><?= $pulsera['precio'] ?></span>
                <button class="btn-line">Ver detalle</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>

