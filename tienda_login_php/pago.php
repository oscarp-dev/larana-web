<?php
// Incluye la función de estado de sesión para asegurar que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Conexión a la base de datos (asumiendo que usa MySQLi o PDO)
require_once "db_connect.php";

// Verificar que haya productos en el carrito
if (empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

// Calcular total del carrito
$total = 0;
foreach ($_SESSION['carrito'] as $it) {
    // Asegurar que la cantidad es numérica para el cálculo
    $cantidad = (int)($it['cantidad'] ?? 1);
    $total += (float)($it['precio'] ?? 0) * $cantidad;
}

// Si el usuario está logueado, podemos precargar algunos datos
$nombre = $direccion = $telefono = "";

// AVISO: El código de conexión de tu db_connect.php usa PDO, pero aquí usas MySQLi ($stmt->bind_param).
// Lo he corregido para que use PDO, que es lo que has estado usando en procesar_pago.php.
if (isset($_SESSION['usuario']['id'])) { // Usando la estructura de sesión del archivo de pago
    $usuario_id = $_SESSION['usuario']['id']; // Asumiendo que esta es la clave correcta
    
    try {
        $stmt = $conn->prepare("SELECT nombre, direccion, telefono FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $usuario_id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $nombre = $userData['nombre'] ?? '';
            $direccion = $userData['direccion'] ?? '';
            $telefono = $userData['telefono'] ?? '';
        }
    } catch (PDOException $e) {
        // Manejo de errores de base de datos
        error_log("Error al cargar datos de usuario: " . $e->getMessage());
    }
}


// INCLUSIONES
include __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="../productos/producto.css">

<style>
/* === ESTILOS CHECKOUT LARANA JEWELRY MEJORADOS === */
.checkout-container {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    margin-top: 30px;
}

/* Tarjetas de cada sección */
.checkout-section {
    flex: 1;
    min-width: 320px;
    background-color: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 15px;
    padding: 35px 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s;
}

.checkout-section:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* Títulos */
.checkout-section h2 {
    font-size: 1.6rem;
    font-weight: 500;
    margin-bottom: 25px;
    border-bottom: 2px solid #b38f53;
    padding-bottom: 10px;
    color: #1a1a1a;
    letter-spacing: 0.5px;
}

/* Tabla de productos */
.checkout-section table {
    width: 100%;
    border-collapse: collapse;
}

.checkout-section th,
.checkout-section td {
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;
    text-align: left;
    font-size: 0.95rem;
}

.checkout-section th {
    font-weight: 600;
    color: #333;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.total-line {
    text-align: right;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 2px solid #f0f0f0;
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a1a1a;
}

/* === FORMULARIO === */
.checkout-form label {
    font-weight: 500;
    color: #1a1a1a;
    margin-top: 10px;
    display: block;
    font-size: 0.95rem;
}

.checkout-form input {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    margin-bottom: 18px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s;
    background-color: #fff;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
}

.checkout-form input:focus {
    border-color: #b38f53;
    background-color: #fff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(179, 143, 83, 0.1);
}

/* === CONTENEDOR FLEX PARA BOTONES DEL MISMO TAMAÑO === */
.button-group {
    display: flex;
    gap: 15px; /* Espacio entre los botones */
    margin-top: 25px;
}

/* === ESTILO DE BOTONES === */
/* NOTA: He añadido una clase específica 'btn-primary-checkout' al botón de Confirmar compra
         para diferenciarlo del 'btn-back', aunque ambos comparten estilos base. */
.btn-action {
    flex-grow: 1; /* CLAVE: Fuerza a ambos botones a tener el mismo ancho */
    text-align: center; /* Centrar el texto en el ancho completo */
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    border: 1px solid transparent; /* Base para ambos */
}

/* Botón principal (Confirmar) */
.btn-primary-checkout {
    background-color: #c6a664; 
    color: #fff;
    border-color: #c6a664;
}

.btn-primary-checkout:hover {
    background-color: #b38f53;
    border-color: #b38f53;
}

/* Botón secundario (Volver al carrito) */
.btn-back {
    border: 1px solid #c6a664; 
    color: #1a1a1a;
    background-color: transparent;
}

.btn-back:hover {
    background-color: #c6a664;
    color: #fff;
}


/* Responsive: Asegurar que en móvil los botones ocupen todo el ancho y se apilen si es necesario */
@media (max-width: 576px) {
    .button-group {
        flex-direction: column;
    }
}
</style>

<main class="container" style="padding: 40px 0;">
    <h1 class="title" style="color:#1a1a1a; text-align:center; margin-bottom: 40px; font-size: 2.5rem; font-weight: 300;">Finalizar compra</h1>

    <div class="checkout-container">

        <section class="checkout-section">
            <h2>Resumen del pedido</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cant.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($_SESSION['carrito'] as $item): 
                    // Asegurar que la cantidad y precio son válidos
                    $cantidad = (int)($item['cantidad'] ?? 1);
                    $precio = (float)($item['precio'] ?? 0);
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= number_format($precio, 2) ?> €</td>
                        <td><?= $cantidad ?></td>
                        <td><?= number_format($precio * $cantidad, 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <p class="total-line">Total del pedido: <?= number_format($total, 2) ?> €</p>
        </section>

        <section class="checkout-section">
            <h2>Datos de envío y pago</h2>
            <form action="procesar_pago.php" method="POST" class="checkout-form">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

                <label for="direccion">Dirección de envío:</label>
                <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($direccion) ?>" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>" required>

                <label for="tarjeta">Número de tarjeta (solo demostración):</label>
                <!-- Evitar que se muestre el valor precargado por seguridad -->
                <input type="text" id="tarjeta" name="tarjeta" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>

                <input type="hidden" name="total" value="<?= $total ?>">

                <div class="button-group">
                    <!-- He cambiado la clase del botón de Confirmar para que use el estilo primario -->
                    <button type="submit" class="btn-action btn-primary-checkout">Confirmar compra</button>
                    <a href="carrito.php" class="btn-action btn-back">Volver al carrito</a>
                </div>
            </form>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>