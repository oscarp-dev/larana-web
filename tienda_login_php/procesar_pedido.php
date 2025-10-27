<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php";

// Verificar usuario logueado
if (empty($_SESSION['usuario']['id'])) {
    header('Location: ./login.php');
    exit;
}

// Verificar carrito
if (empty($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit;
}

// Calcular total
$carrito = $_SESSION['carrito'];
$total = 0.0;

foreach ($carrito as $item) {
    $precio = (float) ($item['precio'] ?? 0);
    $cantidad = (int) ($item['cantidad'] ?? 1);
    $total += $precio * $cantidad;
}

$user_id = (int) $_SESSION['usuario']['id'];

try {
    // Iniciar transacción
    $conn->beginTransaction();

    // 1️⃣ Insertar pedido
    $sqlPedido = "INSERT INTO pedidos (usuario_id, total, estado) VALUES (:usuario_id, :total, 'pendiente')";
    $stmtPedido = $conn->prepare($sqlPedido);
    $stmtPedido->execute([
        ':usuario_id' => $user_id,
        ':total' => $total
    ]);

    // Obtener ID del pedido
    $order_id = $conn->lastInsertId();

    // 2️⃣ Insertar detalles del pedido
    $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio) 
                   VALUES (:pedido_id, :producto_id, :cantidad, :precio)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($carrito as $item) {
        $stmtDetalle->execute([
            ':pedido_id' => $order_id,
            ':producto_id' => $item['id'],
            ':cantidad' => $item['cantidad'],
            ':precio' => $item['precio']
        ]);
    }

    // Confirmar transacción
    $conn->commit();

    // Vaciar carrito
    unset($_SESSION['carrito']);

    // Redirigir con éxito
    header("Location: dashboard.php?pedido=ok&order_id={$order_id}");
    exit;

} catch (Exception $e) {
    // Revertir si hay error
    $conn->rollBack();

    // Mostrar error temporalmente (solo para depuración)
    echo "<pre style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}
?>
