<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "db_connect.php";


// Inicializar carrito
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// ⚡ Detectar si la petición viene desde fetch (AJAX)
$isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';

// ➕ Añadir producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $precio = (float) ($_POST['precio'] ?? 0);

    if (!$id) {
        if ($isAjax) {
            echo json_encode(['ok' => false, 'error' => 'ID inválido']);
            exit;
        }
        header("Location: carrito.php");
        exit;
    }

    // Buscar si ya está en el carrito
    $found = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id) {
            $item['cantidad']++;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => 1
        ];
    }

    //  Si es AJAX → devolvemos JSON
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode([
            'ok' => true,
            'nombre' => $nombre,
            'count' => array_sum(array_column($_SESSION['carrito'], 'cantidad'))
        ]);
        exit;
    }

    //  Si no es AJAX → redirigimos normalmente
    header("Location: carrito.php");
    exit;
}

// ❌ Eliminar
if (isset($_GET['remove'])) {
    $rid = $_GET['remove'];
    $_SESSION['carrito'] = array_values(array_filter($_SESSION['carrito'], fn($p) => $p['id'] != $rid));
    header("Location: carrito.php");
    exit;
}

// 🧹 Vaciar carrito
if (isset($_GET['clear'])) {
    $_SESSION['carrito'] = [];
    header("Location: carrito.php");
    exit;
}

$total = 0;
foreach ($_SESSION['carrito'] as $it) {
    $total += $it['precio'] * ($it['cantidad'] ?? 1);
}

include __DIR__ . '/../includes/header.php';
?>


<link rel="stylesheet" href="../productos/producto.css">

<main class="container" style="padding: 40px 0;">
  <h2 class="title">Tu carrito</h2>

  <?php if (empty($_SESSION['carrito'])): ?>
    <p class="muted">Tu carrito está vacío. Explora la colección y añade tus favoritos.</p>
  <?php else: ?>
    <div style="overflow:auto;">
      <table class="carrito-table" style="width:100%;border-collapse:collapse;margin-top:12px;">
        <thead>
          <tr style="text-align:left;border-bottom:1px solid #eee;">
            <th>Producto</th>
            <th>Precio</th>
            <th style="width:120px;">Cantidad</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['carrito'] as $item): ?>
          <tr style="border-bottom:1px solid #f2f2f2;">
            <td style="padding:12px 8px;"><?= htmlspecialchars($item['nombre']) ?></td>
            <td style="padding:12px 8px;"><?= number_format($item['precio'],2) ?> €</td>
            <td style="padding:12px 8px;"><?= (int)($item['cantidad'] ?? 1) ?></td>
            <td style="padding:12px 8px;"><?= number_format($item['precio'] * ($item['cantidad'] ?? 1),2) ?> €</td>
            <td style="padding:12px 8px;">
              <a href="?remove=<?= urlencode($item['id']) ?>" class="btn-line">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:18px;">
      <div>
        <a href="?clear=1" class="btn-line">Vaciar carrito</a>
      </div>
      <div style="text-align:right;">
        <h3>Total: <?= number_format($total,2) ?> €</h3>
        <a href="pago.php" class="btn-dark">Finalizar pedido</a>
      </div>
    </div>
  <?php endif; ?>

  <a href="/J_S25_Tienda_Online" class="btn-line" style="margin-top:18px;display:inline-block;">Seguir comprando</a>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
