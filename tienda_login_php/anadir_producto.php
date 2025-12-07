<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db_connect.php";
$message = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Si no hay usuario logueado o no es admin, salimos.
if (empty($_SESSION['usuario']) || $_SESSION['usuario']['admin'] !== 1) {
    if (!isset($_GET['is_modal'])) {
        header('Location: login.php');
        exit;
    } else {
        exit('<div class="alert alert-danger">Acceso denegado.</div>');
    }
}

$mensaje = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $destacado = isset($_POST['destacado']) ? 1 : 0;

    // Manejo de imagen - RUTAS CORREGIDAS
    $imagen = $_FILES['imagen']['name'];
    
    // Directorio donde se guardarán las imágenes (relativo al servidor)
    $directorio = $_SERVER['DOCUMENT_ROOT'] . '/J_S25_Tienda_Online/images/';
    
    // Asegurar que el directorio existe
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }
    
    // Generar nombre único para la imagen
    $extension = pathinfo($imagen, PATHINFO_EXTENSION);
    $nombre_imagen = time() . '_' . uniqid() . '.' . $extension;
    $rutaDestino = $directorio . $nombre_imagen;
    
    // Ruta para guardar en la base de datos
    $rutaBD = "images/" . $nombre_imagen;

    // Validar que es una imagen
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check === false) {
        $mensaje = "❌ El archivo no es una imagen válida.";
    } 
    // Validar tamaño (máximo 5MB)
    elseif ($_FILES["imagen"]["size"] > 5000000) {
        $mensaje = "❌ La imagen es demasiado grande (máximo 5MB).";
    }
    // Validar extensión
    elseif(!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $mensaje = "❌ Solo se permiten archivos JPG, JPEG, PNG, GIF y WebP.";
    }
    // Mover el archivo
    elseif (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria, destacado)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $descripcion);
        $stmt->bindValue(3, $precio);
        $stmt->bindValue(4, $stock, PDO::PARAM_INT);
        $stmt->bindValue(5, $rutaBD);
        $stmt->bindValue(6, $categoria);
        $stmt->bindValue(7, $destacado, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $mensaje = "✅ Producto añadido correctamente";
            // Éxito: Recargamos la página principal (perfil.php)
            echo '<script>
                alert("Producto añadido correctamente. El modal se cerrará.");
                // Si la acción fue exitosa, cerramos el modal y recargamos la página padre (perfil.php)
                window.parent.location.reload(); 
            </script>';
            exit;
        } else {
            $mensaje = "❌ Error al guardar en BD: " . $stmt->errorInfo()[2];
        }

    } else {
        $mensaje = "❌ Error al subir la imagen. Directorio: " . $directorio;
    }
}

// ====================================================================
// HTML CONDICIONAL: Si NO es modal, incluimos el layout completo
// ====================================================================
if (!isset($_GET['is_modal'])): 
    include __DIR__ . '/../includes/header.php';
?>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header card-header-dark-elegant text-center">
            <h3 class="m-0">AÑADIR NUEVO PRODUCTO</h3>
        </div>
        <div class="card-body">

<?php endif; // Cierre de !isset($_GET['is_modal']) ?>

<?php if (isset($_GET['is_modal'])): // Si es modal, incluimos encabezados del modal ?>

<div class="modal-header card-header-dark-elegant">
    <h5 class="modal-title m-0 text-white" id="addProductModalLabel">AÑADIR NUEVO PRODUCTO</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">

<?php endif; ?>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo strpos($mensaje, '✅') !== false ? 'success' : 'danger'; ?> text-center">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <form action="anadir_producto.php" method="POST" enctype="multipart/form-data" 
        <?php if (isset($_GET['is_modal'])): ?> target="_self" <?php endif; ?>>

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
            <select name="categoria" class="form-select" required> 
                <option value="Pulseras">Pulseras</option>
                <option value="Collares">Collares</option>
                <option value="Pendientes">Pendientes</option>
                <option value="Anillos">Anillos</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen del Producto</label>
            <input type="file" name="imagen" class="form-control" accept="image/*" required>
            <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF, WebP. Tamaño máximo: 5MB</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="destacado" name="destacado" value="1">
            <label class="form-check-label" for="destacado">Marcar como producto destacado</label>
            <small class="form-text text-muted d-block">Los productos destacados aparecerán en la página principal y en la sección de destacados.</small>
        </div>

        <button type="submit" class="btn btn-dark-elegant w-100 mt-3">Guardar Producto</button>
    </form>
    
<?php if (isset($_GET['is_modal'])): // Cierre de modal ?>

</div>
<div class="modal-footer justify-content-center">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
</div>

<?php else: // Cierre de la versión NO modal ?>

            <br>
            <div class="text-center">
                <a href="perfil.php" class="btn btn-secondary text-white w-50">Volver a perfil</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

<?php endif; ?>