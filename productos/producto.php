<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../tienda_login_php/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='container'><h2>ID de producto no válido</h2></div>";
    exit;
}

// 🔍 Consultar el producto en la base de datos
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = :id");
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() === 0) {
    echo "<div class='container'><h2>Producto no encontrado</h2></div>";
    exit;
}

$producto = $stmt->fetch(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="producto.css">

<section class="producto-detalle container">
  <div class="producto-layout">

    <!-- 🖼️ Imagen -->
    <div class="producto-media">
      <img src="../<?= htmlspecialchars($producto['imagen'])?>" 
           alt="<?= htmlspecialchars($producto['nombre']) ?>">
    </div>

    <!-- ℹ️ Información -->
    <div class="producto-info">
      <h1 class="titulo"><?= htmlspecialchars($producto['nombre']) ?></h1>
      <p class="precio">€<?= htmlspecialchars($producto['precio']) ?></p>
      <p class="precio-info">Impuestos incluidos — Envío gratuito desde 50€</p>

      <form action="../tienda_login_php/carrito.php" method="POST">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
        <input type="hidden" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>">
        <button type="submit" name="add_to_cart" class="btn-dorado">Añadir al carrito</button>
      </form>

      <ul class="atributos">
        <li>💧 Water resistant</li>
        <li>🌿 Hipoalergénico</li>
        <li>💎 Garantía de 3 años</li>
        <li>🔄 Cambios fáciles</li>
      </ul>

      <div class="detalles">
        <details class="detalle" open>
          <summary>Descripción</summary>
          <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
        </details>

        <details class="detalle">
          <summary>Envíos y devoluciones</summary>
          <p>
            Envíos gratuitos a partir de 50€.  
            Entregas entre 2 y 5 días laborables.  
            Cambios y devoluciones disponibles en un plazo de 14 días sin coste adicional.
          </p>
        </details>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
