<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php";

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
$order_id = null;

try {
    // Iniciar transacción
    $conn->beginTransaction();

    $sqlPedido = "INSERT INTO pedidos (usuario_id, total, estado) VALUES (:usuario_id, :total, 'pendiente')";
    $stmtPedido = $conn->prepare($sqlPedido);
    $stmtPedido->execute([
        ':usuario_id' => $user_id,
        ':total' => $total
    ]);

    $order_id = $conn->lastInsertId();

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

    $conn->commit();

    $nombreCliente = $_SESSION['usuario']['nombre'] ?? 'Cliente';
    $emailCliente = $_SESSION['usuario']['email'] ?? null;
    $resumen = "";

    if ($emailCliente) {
        $resumen = "<ul>";
        foreach ($carrito as $producto) {
            $nombre = htmlspecialchars($producto['nombre']);
            $cantidad = (int)$producto['cantidad'];
            $precio = number_format($producto['precio'], 2, ',', '.'); // Ejemplo con formato europeo
            $resumen .= "<li>{$nombre} x {$cantidad} - {$precio}€</li>";
        }
        $resumen .= "</ul>";        
    }

    // Vaciar carrito
    unset($_SESSION['carrito']);

    header("Location: dashboard.php?pedido=ok&order_id={$order_id}");
    exit;

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo "<pre style='color:red;'>Error al procesar el pedido: " . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}
?>