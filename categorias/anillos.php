<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /tienda_login_php/login.php');
    exit;
}

include __DIR__ . '/../includes/header.php'; 
?>

<main class="container opciones">
    <h1>Anillos</h1>
    <p>Bienvenido a la sección de Anillos. Aquí puedes explorar todos nuestros anillos.</p>

    <div class="grid-opciones">
        <?php
        $anillos = [
            ['nombre' => 'Anillo Minimal', 'imagen' => '../images/anillos.jpg', 'precio' => '10€'],
            ['nombre' => 'Anillo Elegante', 'imagen' => '../images/anillos.jpg', 'precio' => '15€'],
            ['nombre' => 'Anillo Colorido', 'imagen' => '../images/anillos.jpg', 'precio' => '12€']
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

<?php include __DIR__ . '/../includes/footer.php'; ?>

