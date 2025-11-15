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

// Lógica para determinar el estado visual
$estado_pago = ucfirst($pedido['estado']);
$estado_clase = '';
$icono_html = '';

if ($pedido['estado'] === 'pagado') {
    $estado_clase = 'status-paid';
    // Icono SVG de cheque (check mark)
    $icono_html = '<svg xmlns="http://www.w3.org/2000/svg" class="status-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
} else {
    $estado_clase = 'status-pending';
    // Icono SVG de reloj (reloj de arena)
    $icono_html = '<svg xmlns="http://www.w3.org/2000/svg" class="status-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
}

include __DIR__ . '/../includes/header.php';
?>

<style>
/* Estilo base para imitar la tipografía y tonos dorados de la web */
:root {
    --color-gold-light: #c6a664; /* Color para hover */
    --color-gold-dark: #b38f53; /* Color principal del botón */
    --color-dark: #1a1a1a;
    --color-status-paid: #38a169;
    --color-status-pending: #d69e2e;
}

/* === CARD DE CONFIRMACIÓN === */
.confirmation-card {
    max-width: 500px;
    margin: 60px auto;
    padding: 40px;
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    text-align: center;
    font-family: Arial, sans-serif;
}

.confirmation-card h2 {
    font-size: 2rem;
    font-weight: 300;
    color: var(--color-dark);
    margin-bottom: 20px;
    border-bottom: 2px solid var(--color-gold-light); /* Usamos el color más claro para el borde del título */
    padding-bottom: 10px;
    display: inline-block;
}

.confirmation-card h3 {
    font-size: 1.4rem;
    font-weight: 500;
    color: var(--color-gold-dark); /* Usamos el color más oscuro para el título h3 */
    margin-top: 25px;
}

.confirmation-card p {
    font-size: 1.05rem;
    line-height: 1.6;
    color: #666;
    margin-bottom: 10px;
}

/* === BLOQUE DE DATOS CLAVE === */
.data-block {
    margin: 30px 0;
    padding: 20px 0;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
}

.data-block p {
    margin: 8px 0;
}

/* === ESTADO DE PAGO === */
.status-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    font-weight: 600;
    font-size: 1.1rem;
}

.status-icon {
    width: 28px;
    height: 28px;
    margin-right: 10px;
}

.status-paid .status-icon {
    color: var(--color-status-paid);
}

.status-pending .status-icon {
    color: var(--color-status-pending);
}

.status-paid span {
    color: var(--color-status-paid);
}

.status-pending span {
    color: var(--color-status-pending);
}

/* === BOTÓN PRIMARIO (Estilo de la web - Oro plano) === */
.btn-primary {
    display: inline-block;
    padding: 12px 30px;
    margin-top: 30px;
    background-color: var(--color-gold-dark); /* Color b38f53 como fondo principal */
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    text-transform: uppercase;
    transition: background-color 0.3s, box-shadow 0.3s;
    border: none; /* Eliminar el reborde */
}

.btn-primary:hover {
    background-color: var(--color-gold-light); /* Color c6a664 en hover */
    color: #fff; /* Mantener texto blanco en hover */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Responsividad simple */
@media (max-width: 600px) {
    .confirmation-card {
        margin: 30px 15px;
        padding: 25px;
    }
}
</style>

<main class="container" style="padding: 20px 0 80px 0;">
    <div class="confirmation-card">
        <h2>Confirmación del pedido</h2>

        <h3>¡Gracias por tu compra, <?= htmlspecialchars($pedido['nombre']) ?>!</h3>
        <p>Hemos recibido tu pedido. Próximamente recibirás un email de confirmación con los detalles y el seguimiento.</p>

        <div class="status-container <?= $estado_clase ?>">
            <?= $icono_html ?>
            <span>Estado del pago: <?= $estado_pago ?></span>
        </div>

        <div class="data-block">
            <p><strong>Número de pedido:</strong> #<?= $pedido['id'] ?></p>
            <p><strong>Fecha del pedido:</strong> <?= date('d/m/Y H:i', strtotime(htmlspecialchars($pedido['fecha']))) ?></p>
            
            <p style="font-size: 1.5rem; font-weight: 700; color: var(--color-dark); margin-top: 15px;">
                Total: <?= number_format($pedido['total'], 2) ?> €
            </p>
        </div>

        <a href="../index.php" class="btn-primary">Volver a la tienda</a>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>