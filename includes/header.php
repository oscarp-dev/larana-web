<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// AJUSTE CRUCIAL: Definir la base URL para rutas absolutas

$base_url = '/J_S25_Tienda_Online';
$usuario = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LARANA JEWELRY</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= $base_url ?>/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= $base_url ?>/style.css">
    
    <?php 
    $rutaActual = $_SERVER['PHP_SELF'];
    if (strpos($rutaActual, '/productos/') !== false): ?>
        <link rel="stylesheet" href="../productos/producto.css">
    <?php endif; ?>

    <?php 
    if (strpos(strtolower($rutaActual), '/tienda_login_php/') !== false): ?>
        <link rel="stylesheet" href="<?= $base_url ?>/tienda_login_php/styles.css">
    <?php endif; ?>

    <style>
        /* Estructura base (Mantenida) */
        .main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            flex-wrap: nowrap;
        }

        .header-left, .header-center, .header-right {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .header-left { width: 35%; justify-content: flex-start; gap: 20px; }
        .header-center { width: 30%; text-align: center; }
        .header-right { 
            width: 35%; 
            justify-content: flex-end; 
            gap: 15px; 
            position: relative; 
            padding-right: 20px; 
        }

        /* Menú principal */
        .top-nav {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: clamp(8px, 2vw, 18px); 
            flex-wrap: nowrap;
        }
        .top-nav a {
            text-decoration: none;
            color: #111;
            font-weight: 500;
            font-size: clamp(0.8rem, 1.2vw, 1rem);
            white-space: nowrap;
        }

        /* Marca */
        .brand {
            font-size: clamp(1.3rem, 2vw, 1.6rem);
            font-weight: bold;
            text-decoration: none;
            color: #111;
            white-space: nowrap;
        }

        /* Enlaces de ayuda y usuario */
        .icon-link svg {
            vertical-align: middle;
        }
        .help-link {
            margin-left: 10px;
            white-space: nowrap;
            font-size: clamp(0.85rem, 1vw, 1rem);
        }

        /* Botón de búsqueda (Lupa) */
        .search-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            z-index: 15; 
            position: relative;
        }
        
        /* 🔥 Breakpoints personalizados (Mantenidos) */
        @media (max-width: 1399px) {
            .top-nav { display: none !important; } 
            .menu-btn { display: inline-flex !important; }
            .help-link { display: none !important; } 
        }

        @media (min-width: 1400px) {
            .menu-btn { display: none !important; }
        }

        /* ---------------------------------------------------------------- */
        /* ESTILOS PARA LA BARRA DE BÚSQUEDA EXPANDIBLE (Ajustados) */
        /* ---------------------------------------------------------------- */

        .search-container {
            position: absolute; 
            top: 50%;
            right: 20px; 
            transform: translateY(-50%);
            
            width: 0; 
            opacity: 0;
            overflow: hidden;
            transition: width 0.3s ease-out, opacity 0.3s ease-out;
            z-index: 10; 
        }

        .search-container.active {
            width: 300px; 
            opacity: 1;
            transition: opacity 0.3s ease-in, width 0.3s ease-in;
        }
        
        /* Ocultar TODOS los elementos dentro de header-right que no sean la barra de búsqueda */
        .header-right.search-active > *:not(.search-container) {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.1s;
        }
        
        /* Estilo Minimalista del Formulario (Ajustados) */
        .search-form {
            display: flex;
            width: 100%;
            height: 40px; 
            border: none;
            border-bottom: 1px solid #ddd; 
            background-color: transparent;
            align-items: center; 
        }
        
        .search-input {
            flex-grow: 1;
            padding: 8px 15px 8px 0; 
            border: none;
            outline: none;
            font-size: 0.95rem;
            background: transparent;
            color: #333;

            /* Eliminar estilos por defecto en Webkit (Chrome, Safari) */
            -webkit-appearance: none; 
            /* Eliminar estilos por defecto en Mozilla (Firefox) */
            -moz-appearance: none;    
            /* Estándar */
            appearance: none;         

            /* Eliminar la 'X' de borrar en Chrome/Safari */
            &::-webkit-search-cancel-button,
            &::-webkit-search-decoration {
                -webkit-appearance: none;
                appearance: none;
                display: none; 
            }

            /* Eliminar la 'X' de borrar en IE/Edge */
            &::-ms-clear,
            &::-ms-reveal {
                display: none;
                width: 0;
                height: 0;
            }

            /* 🔥 NUEVO: Eliminar el fondo azul/color de autocompletado */
            &:-webkit-autofill,
            &:-webkit-autofill:hover, 
            &:-webkit-autofill:focus, 
            &:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0px 1000px white inset !important;
                box-shadow: 0 0 0px 1000px white inset !important;
                -webkit-text-fill-color: #333 !important; /* Asegura el color del texto */
            }
        }

        .search-input::placeholder {
            color: #888;
            font-style: italic;
        }
        
        .search-submit-btn {
            background: none; 
            border: none;
            color: #111;
            padding: 0 5px; 
            cursor: pointer;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-submit-btn:hover {
            color: #b38f53;
        }
        
        /* Asegura que la lupa principal se mantenga en su sitio hasta que desaparezca */
        .search-btn {
            position: relative; 
            z-index: 15; 
        }
        
        /* ---------------------------------------------------------------- */
        /* ESTILOS PARA EL ICONO DEL CARRITO (Mantenidos) */
        /* ---------------------------------------------------------------- */
        .header-right .icon-link {
            position: relative; 
            display: flex; 
            align-items: center;
            justify-content: center;
            line-height: 1; 
        }

        .cart-count {
            position: absolute;
            top: -5px; 
            right: -8px; 
            background-color: #b38f53; 
            color: white;
            font-size: 0.7em;
            font-weight: bold;
            border-radius: 50%; 
            padding: 2px 5px; 
            min-width: 18px; 
            text-align: center;
            line-height: 1.2; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.2); 
            z-index: 1; 
        }
        /* ---------------------------------------------------------------- */


        /* Estilos de botones y textos (Mantenidos) */
        .btn-gold {
            background: linear-gradient(135deg, #d4af37, #b8860b);
            border: none;
            color: #fff;
            font-weight: bold;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #e8c547, #c89b14);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, .2);
        }

        .btn-dark-elegant {
            background: #1a1a1a;
            border: 1px solid #444;
            color: #f1f1f1;
            font-weight: bold;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-dark-elegant:hover {
            background: #000;
            border-color: #666;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
        }

        .text-gold {
            color: #b38f53 !important;
        }
        .text-dark-elegant {
            color: #1a1a1a !important;
        }

        .card-header-dark-elegant {
            background: #1a1a1a;
            border-bottom: 1px solid #444;
            color: #b38f53;
            font-weight: bold;
        }
        .card-header-dark-elegant h3 {
            margin: 0;
        }
    </style>
</head>
<body>
<header class="main-header container-fluid">
    <div class="header-section header-left">
        <button class="btn btn-outline-dark menu-btn me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-label="Menú">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <nav class="top-nav d-flex header-left">
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Pulseras">Pulseras</a>
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Collares">Collares</a>
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Pendientes">Pendientes</a>
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Anillos">Anillos</a>
            <a href="<?= $base_url ?>/categorias/contactame.php">Contáctanos</a>
        </nav>
    </div>

    <div class="header-section header-center">
        <a href="<?= $base_url ?>/index.php" class="brand" aria-label="LARANA JEWELRY">LARANA JEWELRY</a>
    </div>

    <div class="header-section header-right justify-content-right" id="headerRight">
        
        <button type="button" class="icon-link search-btn" title="Buscar" aria-label="Buscar" id="toggleSearchBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-3.5-3.5"/>
            </svg>
        </button>

        <div class="search-container" id="searchContainer">
            <form action="<?= $base_url ?>/tienda_login_php/buscar.php" method="GET" class="search-form">
              <input type="search" name="q" class="search-input" placeholder="Introduce el nombre o tipo de joya..." required>
              <button type="submit" class="search-submit-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-3.5-3.5"/>
                </svg>
              </button>
            </form>
        </div>
        <?php if ($usuario): ?>
            <div class="user-greeting">
                <a href="<?= $base_url ?>/tienda_login_php/perfil.php" class="icon-link" title="Perfil">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                        viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-user-round-check">
                        <path d="M2 21a8 8 0 0 1 13.292-6"/>
                        <circle cx="10" cy="8" r="5"/>
                        <path d="m16 19 2 2 4-4"/>
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <a href="<?= $base_url ?>/tienda_login_php/login.php" class="icon-link" title="Usuario" id="userLoginLink">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 21v-1a7 7 0 0 1 14 0v1"/>
                </svg>
            </a>
        <?php endif; ?>

        <?php
          $count = 0;
          if (isset($_SESSION['carrito'])) {
            $count = array_sum(array_column($_SESSION['carrito'], 'cantidad'));
          }
        ?>
        <a href="<?= $base_url ?>/tienda_login_php/carrito.php" class="icon-link" title="Carrito" aria-label="Carrito">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <span class="cart-count">
                <?= $count ?>
            </span>
        </a>

        <a href="<?= $base_url ?>/tienda_login_php/ayuda.php" class="help-link">¿Qué necesitas?</a>
    </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menú</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="d-flex flex-column">
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Pulseras">Pulseras</a>
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Collares">Collares</a>
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Pendientes">Pendientes</a>
            <a href="<?= $base_url ?>/categorias/categoria.php?categoria=Anillos">Anillos</a>
            <a href="<?= $base_url ?>/categorias/contactame.php">Contáctanos</a>
        </nav>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleSearchBtn = document.getElementById('toggleSearchBtn');
        const searchContainer = document.getElementById('searchContainer');
        const headerRight = document.getElementById('headerRight');
        const searchInput = searchContainer.querySelector('.search-input');

        toggleSearchBtn.addEventListener('click', function() {
            const isActive = searchContainer.classList.toggle('active');
            
            headerRight.classList.toggle('search-active', isActive);

            if (isActive) {
                searchInput.focus();
            } else {
                searchInput.value = '';
            }
        });

        document.addEventListener('click', function(event) {
            const isClickInsideHeaderRight = headerRight.contains(event.target);
            
            if (searchContainer.classList.contains('active') && !isClickInsideHeaderRight) {
                searchContainer.classList.remove('active');
                headerRight.classList.remove('search-active');
                searchInput.value = '';
            }
        });

        searchContainer.querySelector('.search-form').addEventListener('submit', function(e) {
            if (searchInput.value.trim() === "") {
                e.preventDefault();
                searchInput.focus();
            }
        });
    });
</script>

</body>
</html>