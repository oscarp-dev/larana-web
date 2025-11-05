<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../tienda_login_php/db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$categoria = $_GET['categoria'];

if (!$categoria) {
    header("Location: index.php");
    exit;
}

// Consulta productos por categoría
$sql = "SELECT * FROM productos WHERE categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$categoria]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<main class="container opciones">
    <h1><?= htmlspecialchars($categoria) ?></h1>
    <p>Explora nuestra colección de <?= htmlspecialchars($categoria) ?>.</p>

    <div class="grid-productos">
    <?php foreach ($productos as $producto): ?>
        <div class="producto">
            <div class="producto-media">
                <img src="../<?= $producto['imagen'] ?>" 
                    alt="<?= htmlspecialchars($producto['nombre']) ?>">
            </div>
            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
            <span class="precio"><?= $producto['precio'] ?> €</span>
            <a href="../productos/producto.php?id=<?= $producto['id'] ?>" class="btn-line">
                Ver detalle
            </a>
        </div>
    <?php endforeach; ?>
    </div>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
