<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "db_connect.php";

// Verificar si se pasó un ID de pedido
if (empty($_GET['pedido_id'])) {
    echo "<p>No se especificó ningún pedido.</p>";
    exit;
}

$pedido_id = (int) $_GET['pedido_id'];

// Consultar los datos del pedido
$sql = "SELECT p.id, p.total, p.estado, p.fecha, u.nombre
        FROM pedidos p
        JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $pedido_id]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    echo "<p>Pedido no encontrado.</p>";
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<main class="container" style="padding: 40px 0;">
  <h2 class="title">Confirmación del pedido</h2>

  <div style="text-align:center;margin-top:30px;">
    <h3>¡Gracias por tu compra, <?= htmlspecialchars($pedido['nombre']) ?>!</h3>
    <p>Tu pedido <strong>#<?= $pedido['id'] ?></strong> ha sido procesado.</p>
    <p><strong>Estado del pago:</strong> <?= ucfirst($pedido['estado']) ?></p>
    <p><strong>Total:</strong> <?= number_format($pedido['total'], 2) ?> €</p>
    <p><strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha']) ?></p>

    <a href="../index.php" class="btn-dark" style="margin-top:20px;">Volver a la tienda</a>
  </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
