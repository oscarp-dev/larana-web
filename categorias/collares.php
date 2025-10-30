<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../tienda_login_php/login.php');
    exit;
}

include __DIR__ . '/../includes/header.php'; 
?>

<main class="container opciones">
    <h1>Collares</h1>
    <p>Bienvenido a la sección de Collares. Aquí puedes explorar todos nuestros collares.</p>

    <div class="grid-opciones">
        <?php
        // Array de collares de ejemplo
        $collares = [
            ['id' => 1, 'nombre' => 'Collar Minimal', 'imagen' => '../images/collares.jpg', 'precio' => '25€'],
            ['id' => 2, 'nombre' => 'Collar Elegante', 'imagen' => '../images/collares.jpg', 'precio' => '30€'],
            ['id' => 3, 'nombre' => 'Collar Colorido', 'imagen' => '../images/collares.jpg', 'precio' => '28€']
        ];

        foreach ($collares as $collar):
        ?>
            <div class="producto">
                <div class="producto-media">
                    <img src="<?= $collar['imagen'] ?>" alt="<?= htmlspecialchars($collar['nombre']) ?>">
                </div>
                <h3><?= htmlspecialchars($collar['nombre']) ?></h3>
                <span class="precio"><?= $collar['precio'] ?></span>
                <a href="../productos/producto.php?id=<?= $collar['id'] ?>" class="btn-line">Ver detalle</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
