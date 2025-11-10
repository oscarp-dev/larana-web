<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "db_connect.php";

//  Verificar usuario logueado
if (empty($_SESSION['usuario']['id'])) {
    header('Location: ./login.php');
    exit;
}

//  Verificar carrito
if (empty($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit;
}

$usuario_id = (int) $_SESSION['usuario']['id'];
$carrito = $_SESSION['carrito'];

//  Recibir datos del formulario
$nombre    = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono  = trim($_POST['telefono'] ?? '');
$tarjeta   = trim($_POST['tarjeta'] ?? '');
$total     = (float) ($_POST['total'] ?? 0);

// 🔍 Validar campos mínimos
if (empty($nombre) || empty($direccion) || empty($telefono) || empty($tarjeta)) {
    echo "<p style='color:red;'>Faltan datos obligatorios.</p>";
    exit;
}

// 💳 Simular el pago ficticio (en un proyecto real iría aquí la API del banco)
$pago_aprobado = true; // Puedes cambiarlo a rand(0,1) == 1 para pruebas
$estado_pago = $pago_aprobado ? "pagado" : "pendiente";

try {
    //  Iniciar transacción
    $conn->beginTransaction();

    //  Insertar pedido
    $sqlPedido = "INSERT INTO pedidos (usuario_id, fecha, total, estado)
                  VALUES (:usuario_id, NOW(), :total, :estado)";
    $stmtPedido = $conn->prepare($sqlPedido);
    $stmtPedido->execute([
        ':usuario_id' => $usuario_id,
        ':total' => $total,
        ':estado' => $estado_pago
    ]);

    // Obtener ID del pedido creado
    $pedido_id = $conn->lastInsertId();

    //  Insertar detalles del pedido
    $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio)
                   VALUES (:pedido_id, :producto_id, :cantidad, :precio)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($carrito as $item) {
        $stmtDetalle->execute([
            ':pedido_id'   => $pedido_id,
            ':producto_id' => $item['id'],
            ':cantidad'    => $item['cantidad'],
            ':precio'      => $item['precio']
        ]);
    }

    //  Confirmar transacción
    $conn->commit();

    //  Vaciar carrito
    unset($_SESSION['carrito']);

    //  Redirigir a la confirmación
    header("Location: confirmacion.php?pedido_id=" . urlencode($pedido_id));
    exit;

} catch (Exception $e) {
    //  Revertir cambios si hay error
    $conn->rollBack();
    echo "<pre style='color:red;'>Error al procesar el pago: " . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}
?>
