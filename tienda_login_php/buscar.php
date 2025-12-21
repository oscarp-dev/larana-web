<?php
// Inicialización de la sesión y conexión a la BD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db_connect.php'; 

// Incluimos el header para cargar el CSS global (style.css) y la cabecera HTML
include __DIR__ . '/../includes/header.php'; 

// 1. LÓGICA DE BÚSQUEDA
$query = $_GET['q'] ?? '';
$resultados = [];
$db_error_message = $_SESSION['db_error'] ?? null;
unset($_SESSION['db_error']);

if (!empty($query) && isset($conn)) {
    $busqueda_segura = "%" . $query . "%";
    
    // Consulta SQL para buscar por nombre o categoría
    $sql = "SELECT id, nombre, precio, imagen AS imagen_principal, descripcion AS descripcion_corta, categoria 
            FROM productos 
            WHERE nombre LIKE ? OR categoria LIKE ?";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$busqueda_segura, $busqueda_segura]); 
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $resultados = [];
        $db_error_message = "Error en la Consulta SQL: " . $e->getMessage();
    }
} else if (!empty($query) && !isset($conn) && $db_error_message === null) {
    $db_error_message = "La conexión a la base de datos no se pudo establecer.";
}
?>

<style>
    /* Estilos Generales y del Grid (Mantenidos) */
    .search-results-page {
        padding: 50px 20px; 
        max-width: none; 
    }
    
    .grid-productos {
        display: grid;
        grid-template-columns: repeat(4, 1fr); 
        gap: 1.5rem;
        max-width: 1400px; 
        margin: 0 auto;
    }
    
    /* Media Queries para Responsividad (Mantenidas) */
    @media (max-width: 1200px) {
        .grid-productos { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .grid-productos { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .grid-productos { grid-template-columns: 1fr; }
    }


    /* ESTILOS Y EFECTOS MEJORADOS PARA LA TARJETA (.producto) */
    .grid-productos .producto {
        display: flex;
        flex-direction: column;
        justify-content: space-between; 
        height: 100%; 
        padding: 0; 
        text-align: center;
        
        border: none;
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden; 
        
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease; 
    }

    /* EFECTO HOVER: Tarjeta se 'levanta' */
    .grid-productos .producto:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); 
    }
    
    /* ---------------------------------------------------- */
    /* NUEVOS ESTILOS PARA EL REBORDE DE LA FOTO */
    /* ---------------------------------------------------- */
    .producto-media {
        padding: 15px; /* Crea el reborde blanco alrededor de la imagen */
        background-color: #fff;
    }
    
    /* Imagen del producto */
    .producto-media img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease; 
        border-radius: 8px; /* Hace que la imagen tenga esquinas redondeadas */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); /* Sombra sutil solo en la foto */
    }

    /* EFECTO HOVER: Zoom sutil a la imagen */
    .grid-productos .producto:hover .producto-media img {
         transform: scale(1.03); 
    }
    /* ---------------------------------------------------- */

    /* Estilos del contenido interno */
    .producto-content-top {
        flex-grow: 1; 
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding: 0 15px; /* Eliminamos el padding top/bottom para no duplicar */
        padding-bottom: 5px; 
    }
    
    /* Estilo del título */
    .producto h3 {
        font-size: 1.1em;
        margin: 5px 0 8px 0;
        color: #333;
    }
    
    /* Estilo del precio */
    .precio {
        font-size: 1.2em;
        font-weight: 700;
        color: #b38f53;
    }

    /* Estilos de botones */
    .producto-actions {
        margin-top: auto; 
        display: flex; 
        gap: 10px; 
        flex-direction: column; 
        padding: 15px; 
        padding-top: 0;
    }

    .producto-actions .btn-line {
        display: inline-block;
        padding: 10px 15px;
        text-decoration: none;
        border: 1px solid #b38f53; 
        color: #b38f53;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .producto-actions .btn-line:hover,
    .producto-actions form button:hover {
        background-color: #b38f53;
        color: #fff;
        cursor: pointer;
    }
    
    /* Asegurar que el botón del formulario también se vea bien */
    .producto-actions form button {
        padding: 10px 15px;
        border: 1px solid #b38f53;
        background-color: transparent;
        color: #b38f53;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
</style>


<main class="main-content search-results-page">
    <div class="container text-center py-5">
        <section class="mb-5">
            <?php if (!empty($query)): ?>
                <h1 class="page-title" style="color: #b38f53;">Resultados de Búsqueda</h1>
                <p class="page-subtitle">Artículos encontrados para: <strong>"<?= htmlspecialchars($query) ?>"</strong></p>
            <?php endif; ?>
        </section>
    </div>

    <?php if ($db_error_message): ?>
        <div style="text-align: center; padding: 20px; border: 1px solid #ffdddd; background: #fff5f5; color: #cc0000; max-width: 600px; margin: 20px auto;">
            <h4>⚠️ Error del Sistema</h4>
            <p>No se pudo completar la búsqueda debido a un error de Base de Datos.</p>
            <p style="font-size: 0.9em; color: #660000;">Detalle: <?= htmlspecialchars($db_error_message) ?></p>
        </div>
    
    <?php elseif (!empty($query) && !empty($resultados)): ?>
        
        <div class="grid-productos">
            
            <?php foreach ($resultados as $producto): 
                $imagen_path = $base_url . '/' . htmlspecialchars($producto['imagen_principal']);
                $precio_formateado = number_format($producto['precio'], 0); 
            ?>
                <article class="producto">
                    <div class="producto-media">
                        <img src="<?= $imagen_path ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    </div>
                    
                    <div class="producto-content-top">
                        <span class="product-category" style="font-size: 0.8em; color: #999;"><?= htmlspecialchars($producto['categoria'] ?? '') ?></span>
                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                        <span class="precio">€<?= $precio_formateado ?></span>
                    </div>

                    <div class="producto-actions">
                        <a href="../productos/producto.php?id=<?= $producto['id'] ?>" class="btn-line">Descripción</a>
                        
                        <form action="./carrito.php" method="POST">
                            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                            <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                            <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                            <button type="submit" class="btn-line" name="add_to_cart">Añadir al carrito</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>

        </div>

    <?php elseif (!empty($query) && empty($resultados)): ?>
        <div style="text-align: center; padding: 40px; border: 1px dashed #ccc; background-color: #fcfcfc; max-width: 600px; margin: 40px auto;">
            <h3 style="color: #b38f53; margin-bottom: 15px;">😔 No se encontraron resultados</h3>
            <p>No encontramos ningún producto que coincida con la búsqueda: <strong>"<?= htmlspecialchars($query) ?>"</strong>.</p>
            <p style="font-size: 0.9em; color: #888;">Sugerencia: Intenta buscar por una palabra clave diferente.</p>
        </div>
    <?php endif; ?>
</main>

<?php 
include __DIR__ . '/../includes/footer.php'; 
?>