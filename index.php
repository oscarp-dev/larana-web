<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/tienda_login_php/db_connect.php';

$usuario = $_SESSION['usuario'] ?? null;

// Obtener productos destacados (máximo 4)
$sql_destacados = "SELECT * FROM productos WHERE destacado = 1 ORDER BY fecha_creacion DESC LIMIT 4";
$stmt_destacados = $conn->prepare($sql_destacados);
$stmt_destacados->execute();
$productos_destacados = $stmt_destacados->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>LARANA JEWELRY</title>
    <link rel="preload" href="images/hero.jpg" as="image">
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Estilos para la sección de productos destacados */
        .destacados-section {
            padding: 90px 0 80px;
            text-align: center;
            background-color: var(--beige); /* FONDO DIFERENTE */
            margin: 60px 0;
            border-top: 1px solid var(--borde);
            border-bottom: 1px solid var(--borde);
        }
        
        .destacados-section .container {
            max-width: var(--max); /* MISMO ANCHO QUE NUEVA COLECCIÓN */
            padding: 0 5%; /* MENOS PADDING PARA MÁS ANCHO */
            margin: 0 auto;
        }
        
        .destacados-section h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--negro);
            position: relative;
            display: inline-block;
        }
        
        .destacados-section h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background-color: var(--dorado);
            margin: 10px auto 0;
            border-radius: 2px;
        }
        
        .section-subtitle {
            font-family: 'Karla', sans-serif;
            color: #555;
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 40px;
        }
        
        .badge-destacado {
            background-color: var(--dorado);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 30px;
        }
        
        /* GRID CON TARJETAS MÁS ANCHAS - MENOS GAP */
        .grid-productos-destacados {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px; /* MENOS ESPACIO ENTRE TARJETAS */
        }
        
        /* MISMO ESTILO DE PRODUCTOS QUE LA COLECCIÓN PRINCIPAL PERO MÁS ANCHOS */
        .producto-destacado {
            border: 1px solid var(--borde);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,.05);
            padding: 16px 16px 18px;
            transition: transform .25s ease, box-shadow .25s ease;
            position: relative;
            overflow: hidden;
            width: 100%; /* OCUPAN TODO EL ESPACIO DISPONIBLE */
        }
        
        .producto-destacado:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 24px rgba(0,0,0,.10);
        }
        
        .destacado-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--dorado);
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: bold;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .producto-media-destacado {
            width: 100%;
            height: 320px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 14px;
            background: #eee;
        }
        
        .producto-media-destacado img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .producto-destacado h3 {
            font-size: 1.05rem;
            font-weight: 500;
            margin: 0 0 4px;
        }
        
        .precio-destacado {
            display: block;
            color: var(--dorado);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .btn-line-destacado {
            width: 100%;
            background: transparent;
            color: var(--negro);
            border: 1.5px solid var(--dorado);
            border-radius: 10px;
            padding: 9px 14px;
            cursor: pointer;
            transition: all .25s ease;
            font-family: inherit;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        
        .btn-line-destacado:hover {
            background: var(--dorado);
            color: #fff;
        }
        
        .producto-destacado form {
            margin: 0;
        }
        
        a.btn-line-destacado, a.btn-line-destacado:visited {
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        
        .ver-todos-link {
            margin-top: 40px;
        }
        
        .ver-todos-link a {
            color: var(--dorado);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .3s ease;
            font-size: 1.1rem;
        }
        
        .ver-todos-link a:hover {
            color: var(--dorado-osc);
            gap: 12px;
        }
        
        .no-destacados {
            padding: 60px 40px;
            background: #fff;
            border-radius: 12px;
            margin: 20px auto;
            max-width: 600px;
            border: 1px solid var(--borde);
        }
        
        .no-destacados i {
            font-size: 3.5rem;
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .no-destacados h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--negro);
        }
        
        .no-destacados p {
            color: #666;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }
        
        /* RESPONSIVE PARA DESTACADOS - TARJETAS MÁS ANCHAS */
        /* Pantallas grandes de tablet (768px - 1199px): 2 columnas */
        @media (max-width: 1199px) {
            .grid-productos-destacados {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
                max-width: 800px;
                margin: 0 auto;
            }
            
            .destacados-section .container {
                padding: 0 10%;
            }
        }
        
        /* Móviles pequeños (≤ 767px): 1 columna */
        @media (max-width: 767px) {
            .grid-productos-destacados {
                grid-template-columns: 1fr;
                max-width: 450px;
                margin-left: auto;
                margin-right: auto;
                gap: 30px;
            }
            
            .destacados-section h2 {
                font-size: 1.8rem;
            }
            
            .section-subtitle {
                font-size: 1.1rem;
                padding: 0 20px;
            }
            
            .badge-destacado {
                font-size: 0.85rem;
                padding: 4px 12px;
            }
            
            .destacados-section .container {
                padding: 0 20px;
            }
        }
        
        /* Pantallas muy grandes (≥ 1600px) - Aún más ancho */
        @media (min-width: 1600px) {
            .destacados-section .container {
                max-width: 1400px;
            }
            
            .grid-productos-destacados {
                gap: 30px;
            }
        }
        
        /* AJUSTE PARA LA NUEVA COLECCIÓN TAMBIÉN */
        .nueva-coleccion .grid-productos {
            gap: 24px; /* MENOS ESPACIO ENTRE TARJETAS */
        }
        
        @media (max-width: 1199px) {
            .nueva-coleccion .grid-productos {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }
        }
        
        @media (max-width: 767px) {
            .nueva-coleccion .grid-productos {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <section id="hero" class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <p class="hero-subtitle">DESCUBRE LA NUEVA COLECCIÓN</p>
            <h2>Joyas que cuentan tu historia</h2>
            <a href="#productos" class="btn">Descubrir joyas</a>
        </div>
    </section>

    <section id="productos" class="nueva-coleccion container">
        <h2>Nueva colección</h2>
        <div class="grid-productos">
            <article class="producto">
                <div class="producto-media"><img src="images/producto2.jpg" alt="Pulsera Dorada"></div>
                <h3>Pulsera Dorada</h3>
                <span class="precio">€120</span>
                <a href="./productos/producto.php?id=1" class="btn-line">Descripción</a>
                <form action="./tienda_login_php/carrito.php" method="POST">
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="nombre" value="Pulsera Dorada">
                    <input type="hidden" name="precio" value="120">
                    <button type="submit" name="add_to_cart" class="btn-line">Añadir al carrito</button>
                </form>
            </article>
            <article class="producto">
                <div class="producto-media"><img src="images/producto3.jpg" alt="Collar Elegante"></div>
                <h3>Collar Elegante</h3>
                <span class="precio">€150</span>
                <a href="./productos/producto.php?id=2" class="btn-line">Descripción</a>
                <form action="./tienda_login_php/carrito.php" method="POST">
                    <input type="hidden" name="id" value="2">
                    <input type="hidden" name="nombre" value="Collar Elegante">
                    <input type="hidden" name="precio" value="150">
                    <button type="submit" name="add_to_cart" class="btn-line">Añadir al carrito</button>
                </form>
            </article>
            <article class="producto">
                <div class="producto-media"><img src="images/producto1.jpg" alt="Anillo Minimal"></div>
                <h3>Anillo Minimal</h3>
                <span class="precio">€90</span>
                <a href="./productos/producto.php?id=3" class="btn-line">Descripción</a>
                <form action="./tienda_login_php/carrito.php" method="POST">
                    <input type="hidden" name="id" value="3">
                    <input type="hidden" name="nombre" value="Anillo Minimal">
                    <input type="hidden" name="precio" value="90">
                    <button type="submit" name="add_to_cart" class="btn-line">Añadir al carrito</button>
                </form>
            </article>
            <article class="producto">
                <div class="producto-media"><img src="images/producto4.jpg" alt="Pendientes Clásicos"></div>
                <h3>Pendientes Clásicos</h3>
                <span class="precio">€110</span>
                <a href="./productos/producto.php?id=4" class="btn-line">Descripción</a>
                <form action="./tienda_login_php/carrito.php" method="POST">
                    <input type="hidden" name="id" value="4">
                    <input type="hidden" name="nombre" value="Pendientes Clásicos">
                    <input type="hidden" name="precio" value="110">
                    <button type="submit" name="add_to_cart" class="btn-line">Añadir al carrito</button>
                </form>
            </article>
        </div>
        <a href="tienda_login_php/coleccion.php" class="btn-dark">Ver todos los productos</a>
    </section>

    <!-- SECCIÓN DE PRODUCTOS DESTACADOS - MEJORADA -->
    <section id="destacados" class="destacados-section">
        <div class="container"> <!-- MISMO CONTENEDOR QUE NUEVA COLECCIÓN -->
            <h2>Productos Destacados</h2>
            <p class="section-subtitle">Descubre nuestras joyas más exclusivas y populares</p>
            <div class="badge-destacado">
                <i class="fas fa-star me-2"></i>LOS MÁS VENDIDOS
            </div>
            
            <?php if (count($productos_destacados) > 0): ?>
                <div class="grid-productos-destacados"> <!-- GRID ESPECIAL MÁS ANCHO -->
                    <?php foreach ($productos_destacados as $producto): ?>
                        <article class="producto-destacado"> <!-- CLASE ESPECIAL PARA DESTACADOS -->
                            <div class="destacado-badge">
                                <i class="fas fa-crown me-1"></i> Destacado
                            </div>
                            <div class="producto-media-destacado">
                                <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                            </div>
                            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <span class="precio-destacado">€<?= htmlspecialchars($producto['precio']) ?></span>
                            <a href="./productos/producto.php?id=<?= $producto['id'] ?>" class="btn-line-destacado">Ver detalle</a>
                            <form action="./tienda_login_php/carrito.php" method="POST">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
                                <input type="hidden" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>">
                                <button type="submit" name="add_to_cart" class="btn-line-destacado">Añadir al carrito</button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
                
                <div class="ver-todos-link">
                    <a href="tienda_login_php/destacados.php">
                        Ver todos los productos destacados
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="no-destacados">
                    <i class="fas fa-star"></i>
                    <h3>No hay productos destacados</h3>
                    <p>Próximamente añadiremos nuestras joyas más exclusivas.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="historia" class="historia">
        <div class="container historia-inner">
            <div class="historia-img">
                <img src="images/historia.jpg" alt="Sobre LARANA JEWELRY">
            </div>
            <div class="historia-texto">
                <h2>Joyas que cuentan tu historia</h2>
                <p>
                    Cada pieza se diseña para que te acompañe en los instantes que importan y sea
                    el detalle que personaliza tu estilo. Nuestro taller cuida los materiales al detalle.
                </p>
                <a href="tienda_login_php/historia.php" class="btn">Nuestra historia</a>
            </div>
        </div>
    </section>

    <section id="categorias" class="categorias container">
        <h2>Categorías</h2>
        <div class="grid-categorias">
            <a class="categoria" href="categorias/categoria.php?categoria=Pendientes">
                <div class="cat-media"><img src="images/pendientes.jpg" alt="Pendientes"></div>
                <p>Pendientes</p>
            </a>
            <a class="categoria" href="categorias/categoria.php?categoria=Collares">
                <div class="cat-media"><img src="images/collares.jpg" alt="Collares"></div>
                <p>Collares</p>
            </a>
            <a class="categoria" href="categorias/categoria.php?categoria=Pulseras">
                <div class="cat-media"><img src="images/pulsera.jpg" alt="Pulseras"></div>
                <p>Pulseras</p>
            </a>
            <a class="categoria" href="categorias/categoria.php?categoria=Anillos">
                <div class="cat-media"><img src="images/anillos.jpg" alt="Anillos"></div>
                <p>Anillos</p>
            </a>
        </div>
    </section>

    <section id="opciones" class="opciones container">
        <h2>Explora nuestras secciones</h2>
        <p class="subtitle">Descubre el arte en cada pieza y encuentra el estilo que te define.</p> 

        <div class="grid-opciones">
            <a class="btn-opcion" href="categorias/categoria.php?categoria=Pulseras">
                <i class="fas fa-link"></i>
                Pulseras
            </a>
            
            <a class="btn-opcion" href="categorias/categoria.php?categoria=Collares">
                <i class="fas fa-gem"></i>
                Collares
            </a>
            
            <a class="btn-opcion" href="categorias/categoria.php?categoria=Pendientes">
                <i class="fas fa-leaf"></i>
                Pendientes
            </a>
            
            <a class="btn-opcion" href="categorias/categoria.php?categoria=Anillos">
                <i class="fas fa-ring"></i>
                Anillos
            </a>

            <a class="btn-opcion" href="tienda_login_php/artesania.php">
                <i class="fas fa-hand-sparkles"></i>
                Artesanía
            </a>

            <a class="btn-opcion" href="tienda_login_php/historia.php">
                <i class="fas fa-medal"></i>
                Historia
            </a>
            
            <!-- Nuevo enlace para productos destacados -->
            <a class="btn-opcion" href="tienda_login_php/destacados.php">
                <i class="fas fa-star"></i>
                Destacados
            </a>
        </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>