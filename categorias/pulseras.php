<?php
session_start();

// Redirige al login si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header('Location: ../tienda_login_php/login.php');
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<main class="container opciones">
    <h1>Pulseras</h1>
    <p>Bienvenido a la sección de Pulseras. Aquí puedes explorar todas nuestras pulseras.</p>

    <div class="grid-opciones">
        <?php
        // Array de pulseras de ejemplo
        $pulseras = [
            ['id'=>1, 'nombre' => 'Pulsera Minimal', 'imagen' => '../images/pulsera.jpg', 'precio' => '15.00'],
            ['id'=>2, 'nombre' => 'Pulsera Elegante', 'imagen' => '../images/pulsera.jpg', 'precio' => '20.00'],
            ['id'=>3, 'nombre' => 'Pulsera Colorida', 'imagen' => '../images/pulsera.jpg', 'precio' => '18.00'],
            ['id'=>4, 'nombre' => 'Pulsera Clásica', 'imagen' => '../images/pulsera.jpg', 'precio' => '22.00'],
            ['id'=>5, 'nombre' => 'Pulsera Moderna', 'imagen' => '../images/pulsera.jpg', 'precio' => '19.00'],
            ['id'=>6, 'nombre' => 'Pulsera Vintage', 'imagen' => '../images/pulsera.jpg', 'precio' => '25.00']
        ];

        foreach ($pulseras as $pulsera):
        ?>
            <div class="producto">
                <div class="producto-media">
                    <img src="<?= $pulsera['imagen'] ?>" alt="<?= htmlspecialchars($pulsera['nombre']) ?>">
                </div>
                <h3><?= htmlspecialchars($pulsera['nombre']) ?></h3>
                <span class="precio">€<?= htmlspecialchars($pulsera['precio']) ?></span>
                <a href="../productos/producto.php?id=<?= $pulsera['id'] ?>" class="btn-line">Ver detalle</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
