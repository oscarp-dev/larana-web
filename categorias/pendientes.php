<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../tienda_login_php/login.php');
    exit;
}

include __DIR__ . '/../includes/header.php'; 
?>

<main class="container opciones">
    <h1>Pendientes</h1>
    <p>Bienvenido a la sección de pendientes. Aquí puedes explorar todos nuestros pendientes.</p>

    <div class="grid-opciones">
        <?php
        // Array de pendientes con IDs
        $pendientes = [
            ['id' => 1, 'nombre' => 'Pendiente Minimal', 'imagen' => '../images/pendientes.jpg', 'precio' => '18€'],
            ['id' => 2, 'nombre' => 'Pendiente Elegante', 'imagen' => '../images/pendientes.jpg', 'precio' => '22€'],
            ['id' => 3, 'nombre' => 'Pendiente Colorido', 'imagen' => '../images/pendientes.jpg', 'precio' => '20€']
        ];

        foreach ($pendientes as $pendiente):
        ?>
            <div class="producto">
                <div class="producto-media">
                    <img src="<?= $pendiente['imagen'] ?>" alt="<?= htmlspecialchars($pendiente['nombre']) ?>">
                </div>
                <h3><?= htmlspecialchars($pendiente['nombre']) ?></h3>
                <span class="precio"><?= $pendiente['precio'] ?></span>
                <a href="../productos/producto.php?id=<?= $pendiente['id'] ?>" class="btn-line">Ver detalle</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
