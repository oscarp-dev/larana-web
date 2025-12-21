<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php"; 

include __DIR__ . '/../includes/header.php';

try {
    $sql = "SELECT id, nombre, precio, imagen, categoria FROM productos ORDER BY categoria, nombre";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error al cargar productos: " . htmlspecialchars($e->getMessage());
    $productos = [];
}

$project_root_folder = 'J_S25_Tienda_Online';
?>

<main class="main-content">
    
    <div class="container text-center py-5">
        <section class="mb-5">
            <h1 class="page-title">Colección LARANA JEWELRY</h1>
            <p class="page-subtitle">Explora nuestra selección completa de piezas únicas, desde pulseras audaces hasta anillos delicados.</p>
        </section>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center"><?= $error_message ?></div>
        <?php endif; ?>
    </div>

    <div class="product-grid">

        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                
                <div class="product-card">
                    
                    <a href="../productos/producto.php?id=<?= $producto['id'] ?>" class="product-link">
                        <div class="product-image-container">
                            <img 
                                src="/<?= $project_root_folder ?>/<?= str_replace('../', '', htmlspecialchars($producto['imagen'])) ?>" 
                                alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                                class="product-image"
                            >
                        </div>
                    </a>

                    <div class="product-details">
                        <span class="product-category"><?= htmlspecialchars($producto['categoria']) ?></span>
                        <h3 class="product-name">
                            <a href="../productos/producto.php?id=<?= $producto['id'] ?>" class="product-link-name">
                                <?= htmlspecialchars($producto['nombre']) ?>
                            </a>
                        </h3>
                        <p class="product-price"><?= number_format($producto['precio'], 2, ',', '.') ?> €</p>
                        
                        <div class="btn-group">
                            <form action="../tienda_login_php/carrito.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                                <input type="hidden" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>">
                                <button type="submit" name="add_to_cart" class="btn-add-to-cart">AÑADIR AL CARRITO</button>
                            </form>

                            <a href="../productos/producto.php?id=<?= $producto['id'] ?>" class="btn-view-product">VER DESCRIPCIÓN</a>
                            
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center w-100">No hay productos disponibles en este momento.</p>
        <?php endif; ?>

    </div>
</main>

<?php 
include __DIR__ . '/../includes/footer.php'; 
?>