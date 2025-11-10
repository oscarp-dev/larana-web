<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "db_connect.php";

// Verificar que haya productos en el carrito
if (empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

// Calcular total del carrito
$total = 0;
foreach ($_SESSION['carrito'] as $it) {
    $total += $it['precio'] * ($it['cantidad'] ?? 1);
}

// Si el usuario está logueado, podemos precargar algunos datos
$nombre = $direccion = $telefono = "";
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("SELECT nombre, direccion, telefono FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($nombre, $direccion, $telefono);
    $stmt->fetch();
    $stmt->close();
}

include __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="../productos/producto.css">

<style>
/* === ESTILOS CHECKOUT LARANA JEWELRY === */
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
  border: 1px solid #e8e3da; /* dorado claro */
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.03);
  transition: all 0.3s;
}

.checkout-section:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.07);
}

/* Títulos */
.checkout-section h2 {
  font-size: 1.4rem;
  margin-bottom: 20px;
  border-bottom: 1px solid #e8e3da;
  padding-bottom: 8px;
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
  padding: 10px 8px;
  border-bottom: 1px solid #f5f5f5;
  text-align: left;
}

.checkout-section th {
  font-weight: 600;
  color: #333;
}

.total-line {
  text-align: right;
  margin-top: 15px;
  font-size: 1.2rem;
  font-weight: 600;
  color: #111;
}

/* === FORMULARIO === */
.checkout-form label {
  font-weight: 500;
  color: #333;
}

.checkout-form input {
  width: 100%;
  padding: 10px;
  margin-top: 6px;
  margin-bottom: 16px;
  border: 1px solid #d8c69c;
  border-radius: 6px;
  transition: all 0.2s;
  background-color: #fafafa;
}

.checkout-form input:focus {
  border-color: #bfa15a;
  background-color: #fff;
  outline: none;
}

/* === BOTONES === */
.btn-dark {
  background-color: #111;
  color: white;
  padding: 10px 22px;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: 500;
  letter-spacing: 0.3px;
}

.btn-dark:hover {
  background-color: #bfa15a; /* dorado suave */
  color: #111;
}

.btn-line {
  border: 1px solid #bfa15a;
  color: #111;
  padding: 10px 22px;
  border-radius: 20px;
  background-color: transparent;
  font-weight: 500;
  transition: all 0.3s;
}

.btn-line:hover {
  background-color: #bfa15a;
  color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
  .checkout-container {
    flex-direction: column;
  }
}
</style>


<!--  Contenido -->
<main class="container" style="padding: 40px 0;">
  <h2 class="title" style="color:#1a1a1a;">Finalizar compra</h2>

  <div class="checkout-container">

    <!--  Resumen del pedido -->
    <section class="checkout-section">
      <h2>Resumen del pedido</h2>
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['carrito'] as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td><?= number_format($item['precio'], 2) ?> €</td>
            <td><?= (int)($item['cantidad'] ?? 1) ?></td>
            <td><?= number_format($item['precio'] * ($item['cantidad'] ?? 1), 2) ?> €</td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <p class="total-line">Total del pedido: <?= number_format($total, 2) ?> €</p>
    </section>

    <!--  Formulario de pago -->
    <section class="checkout-section">
      <h2>Datos de pago</h2>
      <form action="procesar_pago.php" method="POST" class="checkout-form">
        <label>Nombre completo:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

        <label>Dirección de envío:</label>
        <input type="text" name="direccion" value="<?= htmlspecialchars($direccion) ?>" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($telefono) ?>" required>

        <label>Número de tarjeta (solo demostración):</label>
        <input type="text" name="tarjeta" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>

        <input type="hidden" name="total" value="<?= $total ?>">

        <div style="text-align:center;margin-top:10px;">
          <button type="submit" class="btn-dark">Confirmar compra</button>
          <a href="carrito.php" class="btn-line" style="margin-left:10px;">Volver al carrito</a>
        </div>
      </form>
    </section>
  </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
