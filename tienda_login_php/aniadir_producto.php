<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php";
$message = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Si no hay usuario logueado, redirige
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];

if ($_SESSION['usuario']['admin'] !== 1) {
    exit("Acceso denegado");
}

$mensaje = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];

    // Manejo de imagen
    $imagen = $_FILES['imagen']['name'];
    $directorio = __DIR__ . "/../images/";
    $rutaDestino = $directorio . basename($imagen);

    
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {

        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $descripcion);
        $stmt->bindValue(3, $precio);
        $stmt->bindValue(4, $stock, PDO::PARAM_INT);
        $rutaBD = "images/" . $imagen; 
        $stmt->bindValue(5, $rutaBD);
        $stmt->bindValue(6, $categoria);

        if ($stmt->execute()) {
            $mensaje = "✅ Producto añadido correctamente";
        } else {
            $mensaje = "❌ Error al guardar en BD";
        }

    } else {
        $mensaje = "❌ Error al subir la imagen";
    }
}

include __DIR__ . '/../includes/header.php';

?>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header card-header-dark-elegant text-center">
            <h3 class="m-0">AÑADIR NUEVO PRODUCTO</h3>
        </div>
        <div class="card-body">

            <form action="aniadir_producto.php" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" step="1" name="stock" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" required> 
                        <option value="Pulseras">Pulsera</option>
                        <option value="Collares">Collar</option>
                        <option value="Pendientes">Pendiente</option>
                        <option value="Anillos">Anillo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen del Producto</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-dark-elegant text-gold w-100">Guardar Producto</button>
            </form>
            <br>
            <div class="text-center">
                <a href="perfil.php" class="btn btn-secondary text-white w-50">Volver a perfil</a>
            </div>
        </div>
    </div>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
