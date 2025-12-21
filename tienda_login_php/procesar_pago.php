<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "db_connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Autoload Resend
require __DIR__ . '/../vendor/autoload.php';

use Resend\Client;
use Resend\ValueObjects\Transporter\BaseUri;
use Resend\ValueObjects\Transporter\Headers;
use Resend\Transporters\HttpTransporter;
use GuzzleHttp\Client as GuzzleClient;

// Configuración Resend
$headers = new Headers([
    'Authorization' => 'Bearer re_2iR3nNpF_7eWaaZvb98kmURyDVaoTfYVp',
    'Content-Type'  => 'application/json',
]);

$baseUri = new BaseUri('https://api.resend.com');
$guzzle = new GuzzleClient(['timeout' => 30]);
$transporter = new HttpTransporter($guzzle, $baseUri, $headers);

// Verificar login
if (empty($_SESSION['usuario']['id'])) {
    header('Location: login.php');
    exit;
}

// Verificar carrito
if (empty($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit;
}

$usuario_id = (int) $_SESSION['usuario']['id'];
$carrito = $_SESSION['carrito'];

// Recibir datos del formulario
$nombre    = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono  = trim($_POST['telefono'] ?? '');
$tarjeta   = trim($_POST['tarjeta'] ?? '');
$total     = (float) ($_POST['total'] ?? 0);

if (!$nombre || !$direccion || !$telefono || !$tarjeta) {
    echo "<p style='color:red;'>Faltan datos obligatorios.</p>";
    exit;
}

$pago_aprobado = true;
$estado_pago = $pago_aprobado ? "pagado" : "pendiente";

try {
    file_put_contents('/tmp/debug_pago.log', "ANTES beginTransaction\n", FILE_APPEND);
    $conn->beginTransaction();
    file_put_contents('/tmp/debug_pago.log', "DESPUÉS beginTransaction\n", FILE_APPEND);

    // Crear pedido
    $sqlPedido = "INSERT INTO pedidos (usuario_id, fecha, total, estado_pago)
                  VALUES (:usuario_id, NOW(), :total, :estado_pago)";
    $stmtPedido = $conn->prepare($sqlPedido);
    $stmtPedido->execute([
        ':usuario_id' => $usuario_id,
        ':total' => $total,
        ':estado_pago' => $estado_pago
    ]);

    $pedido_id = $conn->lastInsertId();

    // Insertar detalles
    $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio)
                   VALUES (:pedido_id, :producto_id, :cantidad, :precio)";
    $stmtDetalle = $conn->prepare($sqlDetalle);
    error_log("DEBUG CARRITO: " . print_r($carrito, true));

    foreach ($carrito as $item) {
        $stmtDetalle->execute([
            ':pedido_id'   => $pedido_id,
            ':producto_id' => $item['id'],
            ':cantidad'    => $item['cantidad'],
            ':precio'      => $item['precio']
        ]);
    }

    $conn->commit();

    // Obtener email + nombre del cliente
    $stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = :usuario_id");
    $stmt->execute([':usuario_id' => $usuario_id]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    $nombreCliente = $userData['nombre'];
    $emailCliente = $userData['email'];

    // Crear resumen
    $resumen = "<ul>";
    foreach ($carrito as $producto) {
        $resumen .= "<li>{$producto['nombre']} x {$producto['cantidad']} - " .
                    number_format($producto['precio'], 2, ',', '.') . "€</li>";
    }
    $resumen .= "</ul>";

    unset($_SESSION['carrito']);

    // Enviar correo antes del header
    if ($emailCliente) {

        $totalFormatted = number_format($total, 2, ',', '.');

        $html = "
            <h2>¡Gracias por tu compra, {$nombreCliente}!</h2>
            <p>Hemos recibido tu pedido <strong>#{$pedido_id}</strong> correctamente.</p>
            <p><strong>Resumen del pedido:</strong></p>
            {$resumen}
            <p><strong>Total:</strong> {$totalFormatted}€</p>
            <p>Tu pedido está siendo procesado.</p>
            <br>
            <p><strong>LARANA</strong></p>
        ";

        $resend = new Client($transporter);

        /* $resend = new Client('re_dW8zcbBX_PHDAadXdqLj5DkD3AmztV3LD'); */

        try {
            $response = $resend->emails->send([
                'from' => 'LARANA <onboarding@resend.dev>',
                // 'to' => [$emailCliente],  -- No se pueden enviar correos a emails externos hasta que no se haya confirmado un dominio
                'to' => ['empresa.prueba.correo.s25@gmail.com'],
                'subject' => "Confirmación de tu pedido #{$pedido_id}",
                'html' => $html,
            ]);

            // Opcional: ver respuesta
            // var_dump($response);

        } catch (Exception $e) {
            error_log("ERROR ENVIANDO EMAIL: " . $e->getMessage());
        }
    }

    // Ahora sí, redirigir
    header("Location: confirmacion.php?pedido_id={$pedido_id}");
    exit;

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "<pre style='color:red;'>Error al procesar el pago: " . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}
?>
