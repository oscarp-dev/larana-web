<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos - RUTA CORREGIDA
// Ajustamos la ruta para que funcione desde cualquier ubicación
$db_path = __DIR__ . '/db_connect.php';
if (file_exists($db_path)) {
    require_once $db_path;
} else {
    // Intentar con ruta alternativa si está en otro directorio
    $db_path_alt = dirname(__DIR__) . '/tienda_login_php/db_connect.php';
    if (file_exists($db_path_alt)) {
        require_once $db_path_alt;
    } else {
        die("Error: No se pudo encontrar el archivo de conexión a la base de datos.");
    }
}

// --- LÓGICA DE PRODUCTOS DESTACADOS Y BÚSQUEDA ---

// Inicializar la variable de búsqueda y limpiarla
$busqueda = isset($_GET['s']) ? trim($_GET['s']) : '';

// Consulta base para obtener solo productos destacados
$sql_destacados = "SELECT * FROM productos WHERE destacado = 1";

// Parámetros para la consulta
$params = [];

// Si hay un término de búsqueda, añadir la condición de filtro
if (!empty($busqueda)) {
    // Buscar por nombre, descripción O categoría - CORREGIDO: parámetros separados
    $sql_destacados .= " AND (LOWER(nombre) LIKE :busqueda_nombre OR 
                               LOWER(descripcion) LIKE :busqueda_desc OR 
                               LOWER(categoria) LIKE :busqueda_cat)";
    
    // Preparar el término de búsqueda con comodines
    $termino_busqueda = '%' . strtolower($busqueda) . '%';
    
    // Asignar el mismo valor a los tres parámetros
    $params[':busqueda_nombre'] = $termino_busqueda;
    $params[':busqueda_desc'] = $termino_busqueda;
    $params[':busqueda_cat'] = $termino_busqueda;
}

// Ordenar por fecha de creación (los más recientes primero)
$sql_destacados .= " ORDER BY fecha_creacion DESC";

// Flag para debug
$db_error = false;
$productos_a_mostrar = [];
$error_message = '';

try {
    // Verificar si la conexión existe antes de usarla
    if (!isset($conn) || $conn === false || $conn === null) {
        throw new PDOException("La conexión a la base de datos no está disponible.");
    }
    
    // Preparar la consulta
    $stmt_destacados = $conn->prepare($sql_destacados);

    // Vincular parámetros si existen
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $stmt_destacados->bindValue($key, $value, PDO::PARAM_STR);
        }
    }

    $stmt_destacados->execute();
    $productos_a_mostrar = $stmt_destacados->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Error en la consulta de destacados: " . $e->getMessage());
    $db_error = true;
    $error_message = $e->getMessage();
    $productos_a_mostrar = []; // Asegurar array vacío si hay error
}

// INCLUIR HEADER.
// Ajustamos la ruta según la ubicación actual
$header_path = dirname(__DIR__) . '/includes/header.php';
if (file_exists($header_path)) {
    include $header_path;
} else {
    // Ruta alternativa
    $header_path_alt = __DIR__ . '/../includes/header.php';
    if (file_exists($header_path_alt)) {
        include $header_path_alt;
    } else {
        // Header mínimo si no se encuentra
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>LARANA JEWELRY</title></head><body>';
    }
}
?>

    <title>Productos Destacados | LARANA JEWELRY</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ESTILOS UNIFICADOS - IGUAL CON O SIN BÚSQUEDA */
        body { 
            padding-top: 85px; 
            background-color: #fafafa;
        }
        
        .container { 
            max-width: 1400px; 
            padding: 0 20px;
        }
        
        .wrapper-destacados { 
            padding: 40px 0 80px; 
            min-height: 70vh; 
        }
        
        .titulo-seccion { 
            font-family: 'Times New Roman', serif; 
            color: #222; 
            font-size: 2.8rem; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            margin-bottom: 10px; 
            text-align: center;
            font-weight: 300;
        }
        
        .subtitulo-seccion { 
            font-family: 'Karla', sans-serif; 
            color: #666; 
            text-align: center; 
            margin-bottom: 50px; 
            font-weight: 300;
            font-size: 1.1rem;
        }
        
        .search-highlight {
            color: #C6A664;
            font-weight: 600;
        }
        
        /* FORMULARIO DE BÚSQUEDA - ESTILO MEJORADO */
        .destacados-search-form { 
            max-width: 700px; 
            margin: 0 auto 50px; 
            display: flex; 
            gap: 10px; 
            position: relative;
        }
        
        .destacados-search-form input[type="search"] { 
            flex-grow: 1; 
            padding: 14px 20px; 
            border: 1px solid #eaeaea; 
            border-radius: 10px; 
            font-family: 'Karla', sans-serif; 
            font-size: 1rem; 
            transition: all 0.3s ease;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .destacados-search-form input[type="search"]:focus { 
            border-color: #C6A664; 
            box-shadow: 0 0 0 3px rgba(198, 166, 100, 0.15); 
            outline: none;
        }
        
        .destacados-search-form button { 
            background: #C6A664; 
            color: white; 
            border: none; 
            border-radius: 10px; 
            padding: 0 25px; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: inherit;
            font-weight: 500;
            min-width: 100px;
        }
        
        .destacados-search-form button:hover { 
            background: #b38f53; 
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(179, 143, 83, 0.2);
        }
        
        .btn-limpiar-destacados { 
            width: auto; 
            margin-bottom: 0 !important; 
            padding: 14px 20px; 
            border-radius: 10px; 
            text-decoration: none; 
            color: #222; 
            border: 1px solid #eaeaea; 
            background: #fff; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .btn-limpiar-destacados:hover { 
            background: #f8f8f8; 
            color: #222;
            border-color: #ddd;
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        /* GRID DE PRODUCTOS - IGUAL QUE SIN BÚSQUEDA */
        .grid-destacados {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 20px;
        }
        
        @media (max-width: 1200px) {
            .grid-destacados {
                grid-template-columns: repeat(3, 1fr);
                gap: 25px;
            }
        }
        
        @media (max-width: 768px) {
            .grid-destacados {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .grid-destacados {
                grid-template-columns: 1fr;
                gap: 25px;
                max-width: 350px;
                margin-left: auto;
                margin-right: auto;
            }
            
            .destacados-search-form {
                flex-direction: column;
            }
            
            .btn-limpiar-destacados {
                justify-content: center;
            }
        }
        
        /* TARJETA DE PRODUCTO - ESTILO UNIFICADO */
        .producto-destacado { 
            border: 1px solid #f0f0f0; 
            border-radius: 15px; 
            background: #fff; 
            box-shadow: 0 5px 15px rgba(0,0,0,.08); 
            padding: 20px; 
            transition: all 0.3s ease; 
            position: relative; 
            overflow: hidden; 
            height: 100%; 
            display: flex; 
            flex-direction: column;
        }
        
        .producto-destacado:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 15px 30px rgba(0,0,0,.12); 
        }
        
        .destacado-badge { 
            position: absolute; 
            top: 15px; 
            right: 15px; 
            background: #C6A664; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: 600; 
            z-index: 2; 
            display: flex; 
            align-items: center; 
            gap: 5px;
            letter-spacing: 0.5px;
        }
        
        .producto-media-destacado { 
            width: 100%; 
            height: 280px; 
            border-radius: 12px; 
            overflow: hidden; 
            margin-bottom: 20px; 
            background: #f8f8f8;
            position: relative;
        }
        
        .producto-media-destacado img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            display: block;
            transition: transform 0.5s ease;
        }
        
        .producto-destacado:hover .producto-media-destacado img {
            transform: scale(1.05);
        }
        
        .producto-destacado h3 { 
            font-size: 1.1rem; 
            font-weight: 500; 
            margin: 0 0 10px; 
            flex-grow: 1; 
            color: #333;
            line-height: 1.4;
            font-family: 'Karla', sans-serif;
        }
        
        .precio-destacado { 
            display: block; 
            color: #C6A664; 
            font-weight: 600; 
            margin-bottom: 15px; 
            font-size: 1.3rem;
            font-family: 'Karla', sans-serif;
        }
        
        .btn-line-destacado { 
            width: 100%; 
            background: transparent; 
            color: #222; 
            border: 2px solid #C6A664; 
            border-radius: 10px; 
            padding: 12px 14px; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            font-family: 'Karla', sans-serif; 
            text-decoration: none; 
            display: block; 
            text-align: center; 
            margin-bottom: 10px; 
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .btn-line-destacado:hover { 
            background: #C6A664; 
            color: #fff; 
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(198, 166, 100, 0.2);
        }
        
        .producto-destacado form:last-of-type button.btn-line-destacado { 
            margin-bottom: 0; 
        }
        
        /* ESTILOS PARA RESULTADOS */
        .no-results { 
            padding: 80px 40px; 
            background: #fff; 
            border-radius: 15px; 
            margin: 30px auto; 
            max-width: 600px; 
            border: 1px solid #eaeaea; 
            text-align: center; 
            box-shadow: 0 5px 15px rgba(0,0,0,.05);
        }
        
        .no-results i { 
            font-size: 4rem; 
            color: #e0e0e0; 
            margin-bottom: 25px; 
        }
        
        .no-results h3 { 
            font-size: 1.5rem; 
            color: #555; 
            margin-bottom: 15px;
            font-weight: 400;
            font-family: 'Karla', sans-serif;
        }
        
        .no-results p {
            color: #777;
            font-size: 1rem;
            line-height: 1.6;
        }
        
        /* CONTADOR DE RESULTADOS */
        .result-count {
            text-align: center;
            color: #888;
            font-size: 1rem;
            margin-bottom: 30px;
            font-family: 'Karla', sans-serif;
        }
        
        .result-count strong {
            color: #C6A664;
            font-weight: 600;
        }
        
        /* ERROR DE BASE DE DATOS */
        .db-error { 
            padding: 60px 40px; 
            background: #fff8f8; 
            border-radius: 12px; 
            margin: 20px auto; 
            max-width: 700px; 
            border: 1px solid #ffdddd; 
            text-align: center; 
            color: #cc0000;
        }
        
        .db-error i { 
            font-size: 3.5rem; 
            color: #ff6b6b; 
            margin-bottom: 20px; 
        }
        
        .db-error h3 { 
            font-size: 1.5rem; 
            margin-bottom: 15px; 
            color: #cc0000;
        }
    </style>
</head>

<body>

<div class="wrapper-destacados">
    
    <div class="container">
        <h1 class="titulo-seccion">Colección Destacada</h1>
        
        <p class="subtitulo-seccion">
            Descubre nuestras joyas más exclusivas y populares
            <?php if (!empty($busqueda)): ?>
            <br><span class="search-highlight">Buscando: "<?= htmlspecialchars($busqueda) ?>"</span>
            <?php endif; ?>
        </p>

        <!-- FORMULARIO DE BÚSQUEDA -->
        <form action="" method="GET" class="destacados-search-form">
            <input type="search" name="s" placeholder="Buscar en productos destacados..." 
                   value="<?= htmlspecialchars($busqueda) ?>"
                   aria-label="Buscar productos destacados">
            <button type="submit" title="Buscar productos">
                <i class="fas fa-search me-2"></i> Buscar
            </button>
            <?php if (!empty($busqueda)): ?>
                <a href="destacados.php" class="btn-limpiar-destacados" title="Limpiar la búsqueda actual">
                    <i class="fas fa-times me-2"></i> Limpiar
                </a>
            <?php endif; ?>
        </form>
        
        <!-- CONTADOR DE RESULTADOS -->
        <?php if (!empty($busqueda) && !$db_error): ?>
        <div class="result-count">
            <?php if (count($productos_a_mostrar) > 0): ?>
                Se encontraron <strong><?= count($productos_a_mostrar) ?></strong> producto(s) destacado(s)
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <!-- MENSAJE DE ERROR -->
        <?php if ($db_error): ?>
            <div class="db-error">
                <i class="fas fa-database"></i>
                <h3>Error de Base de Datos</h3>
                <p>No se pudo completar la consulta. Por favor, inténtalo de nuevo más tarde.</p>
                <?php if (!empty($error_message)): ?>
                    <p style="font-size: 0.9em; margin-top: 10px; color: #990000;">
                        <strong>Detalle técnico:</strong> <?= htmlspecialchars(substr($error_message, 0, 100)) ?>...
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- GRID DE PRODUCTOS -->
        <?php if (!$db_error): ?>
            <?php if (count($productos_a_mostrar) > 0): ?>
                <div class="grid-destacados">
                    <?php foreach ($productos_a_mostrar as $producto): 
                        // Asegurar que la ruta de la imagen sea correcta
                        $imagen_path = '';
                        if (strpos($producto['imagen'], 'http') === 0) {
                            $imagen_path = $producto['imagen'];
                        } elseif (strpos($producto['imagen'], 'images/') === 0) {
                            $imagen_path = '../' . $producto['imagen'];
                        } elseif (strpos($producto['imagen'], '../images/') === 0) {
                            $imagen_path = $producto['imagen'];
                        } else {
                            $imagen_path = '../images/' . basename($producto['imagen']);
                        }
                    ?>
                        <article class="producto-destacado"> 
                            
                            <div class="destacado-badge"> 
                                <i class="fas fa-crown"></i> Destacado
                            </div>
                            
                            <div class="producto-media-destacado"> 
                                <img src="<?= $imagen_path ?>" 
                                     alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                     onerror="this.onerror=null; this.src='../images/default-product.jpg';"
                                     loading="lazy">
                            </div>
                            
                            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <span class="precio-destacado">€<?= number_format($producto['precio'], 2) ?></span>
                            
                            <a href="../productos/producto.php?id=<?= $producto['id'] ?>" class="btn-line-destacado">
                                <i class="fas fa-eye me-2"></i> Ver detalles
                            </a>
                            
                            <form action="carrito.php" method="POST">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                                <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                                <button type="submit" name="add_to_cart" class="btn-line-destacado">
                                    <i class="fas fa-shopping-bag me-2"></i> Añadir al carrito
                                </button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>
                        <?php if (!empty($busqueda)): ?>
                            No encontramos productos destacados
                        <?php else: ?>
                            No hay productos destacados disponibles
                        <?php endif; ?>
                    </h3>
                    <p>
                        <?php if (!empty($busqueda)): ?>
                            No hay productos destacados que coincidan con "<strong><?= htmlspecialchars($busqueda) ?></strong>".
                        <?php else: ?>
                            Próximamente añadiremos nuevas joyas destacadas.
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($busqueda)): ?>
                        <a href="destacados.php" class="btn-line-destacado mt-4" style="max-width: 200px; margin: 20px auto 0;">
                            <i class="fas fa-undo me-2"></i> Ver todos los destacados
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php 
$footer_path = dirname(__DIR__) . '/includes/footer.php';
if (file_exists($footer_path)) {
    include $footer_path;
} else {
    $footer_path_alt = __DIR__ . '/../includes/footer.php';
    if (file_exists($footer_path_alt)) {
        include $footer_path_alt;
    } else {
        echo '</body></html>';
    }
}
?>