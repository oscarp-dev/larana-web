<?php
// tienda_login_php/procesar_pedido.php
// Procesa un pedido: lo guarda en la tabla `pedidos` de la base de datos `tienda`,
// limpia el carrito en sesión y devuelve JSON si se solicita vía AJAX.
//
// Requisitos:
// - db_connect.php debe definir $conn (mysqli) y conectar con la DB 'tienda'.
// - session must be available and user logged in with $_SESSION['user_id']
// - $_SESSION['carrito'] debe contener el carrito (array de items con id,nombre,precio,cantidad)
//
// Uso normal (no-AJAX):
// - POST desde un formulario -> redirige a dashboard.php?pedido=ok
// Uso AJAX:
// - POST con campo 'ajax' = 1 -> devuelve JSON { ok: true, order_id: 123 }

require_once "db_connect.php"; // debe definir $conn (mysqli)

// Verificar usuario logueado
if (!isset($_SESSION['user_id'])) {
    // Si es AJAX, devolver JSON con error
    if (!empty($_POST['ajax'])) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'not_logged_in']);
        exit;
    }
    header('Location: login.php');
    exit;
}

// Verificar carrito
if (empty($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    if (!empty($_POST['ajax'])) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'empty_cart']);
        exit;
    }
    header('Location: carrito.php');
    exit;
}

// Calcular total y normalizar productos
$carrito = $_SESSION['carrito'];
$total = 0.0;
$normalized = [];

foreach ($carrito as $item) {
    $precio = isset($item['precio']) ? (float)$item['precio'] : 0.0;
    $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
    if ($cantidad < 1) $cantidad = 1;
    $subtotal = $precio * $cantidad;
    $total += $subtotal;

    $normalized[] = [
        'id' => $item['id'] ?? null,
        'nombre' => $item['nombre'] ?? '',
        'precio' => $precio,
        'cantidad' => $cantidad,
        'subtotal' => $subtotal
    ];
}

// Preparar datos para insertar
$user_id = (int) $_SESSION['user_id'];
$productos_json = json_encode($normalized, JSON_UNESCAPED_UNICODE);

// Inicio de transacción para mayor seguridad
$use_transaction = true;
try {
    if ($use_transaction) {
        $conn->begin_transaction();
    }

    $sql = "INSERT INTO pedidos (user_id, productos, total) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('prepare_failed: ' . $conn->error);
    }

    $stmt->bind_param('isd', $user_id, $productos_json, $total);
    if (!$stmt->execute()) {
        throw new Exception('execute_failed: ' . $stmt->error);
    }

    $order_id = $conn->insert_id;
    $stmt->close();

    // Si quieres guardar campos adicionales (dirección, método pago), aquí iría la lógica.
    // Por ejemplo:
    // if (!empty($_POST['direccion'])) { ... guardar en tabla pedidos_direcciones ... }

    if ($use_transaction) {
        $conn->commit();
    }

    // Limpiar carrito solo si la inserción fue exitosa
    unset($_SESSION['carrito']);

    // Respuesta AJAX
    if (!empty($_POST['ajax'])) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok' => true,
            'order_id' => $order_id,
            'total' => round($total, 2)
        ]);
        exit;
    }

    // Redirección normal
    header("Location: dashboard.php?pedido=ok&order_id={$order_id}");
    exit;

} catch (Exception $e) {
    // Rollback si hay transacción
    if ($use_transaction && $conn->errno) {
        $conn->rollback();
    }

    // Loguear el error para debugging en servidor (no mostrar detalles al usuario)
    error_log('procesar_pedido error: ' . $e->getMessage());

    if (!empty($_POST['ajax'])) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'server_error']);
        exit;
    }

    // En modo navegador, redirigir con error (puedes mostrar un mensaje en dashboard.php)
    header("Location: carrito.php?error=server");
    exit;
}
