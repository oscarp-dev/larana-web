<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$usuario = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LARANA JEWELRY</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Estilos globales -->
  <link rel="stylesheet" href="../style.css">

  <!-- Estilos de producto (solo si estás en la carpeta productos) -->
  <?php 
  $rutaActual = $_SERVER['PHP_SELF'];
  if (strpos($rutaActual, '/productos/') !== false): ?>
    <link rel="stylesheet" href="/J_S25_Tienda_Online/productos/producto.css">
  <?php endif; ?>

  <style>
    /* Estructura base */
    /* Estructura base */
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
    .header-right { width: 35%; justify-content: flex-end; gap: 15px; }

    /* Menú principal */
    .top-nav {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: clamp(8px, 2vw, 18px);     /* espacio adaptable */
      flex-wrap: nowrap;
    }
    .top-nav a {
      text-decoration: none;
      color: #111;
      font-weight: 500;
      font-size: clamp(0.8rem, 1.2vw, 1rem); /* tamaño de texto adaptable */
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

    /* 🔥 Breakpoints personalizados */
    @media (max-width: 1399px) {
      .top-nav {
        display: none !important;     /* Oculta menú completo */
      }
      .menu-btn {
        display: inline-flex !important; /* Muestra hamburguesa */
      }
      .help-link {
        display: none !important;     /* Oculta "¿Qué necesitas?" */
      }
    }

    @media (min-width: 1400px) {
      .menu-btn {
        display: none !important;     /* Oculta hamburguesa en pantallas grandes */
      }
    }

  </style>
</head>
  
<header class="main-header container-fluid">
  <!-- Sección izquierda -->
  <div class="header-section header-left">
    <!-- 🔧 Botón hamburguesa visible solo <1400px -->
    <button class="btn btn-outline-dark menu-btn me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-label="Menú">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Menú de navegación (solo visible ≥1400px) -->
    <nav class="top-nav d-flex header-left">
      <a href="pulseras.php">Pulseras</a>
      <a href="collares.php">Collares</a>
      <a href="brazaletes.php">Brazaletes</a>
      <a href="anillos.php">Anillos</a>
      <a href="contactame.php">Contáctanos</a>
    </nav>
  </div>

  <!-- Sección centro -->
  <div class="header-section header-center">
    <a href="./index.php#hero" class="brand" aria-label="LARANA JEWELRY">LARANA JEWELRY</a>
  </div>

  <!-- Sección derecha -->
  <div class="header-section header-right justify-content-right">
    <a href="#" class="icon-link" title="Buscar" aria-label="Buscar">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"/><path d="M21 21l-3.5-3.5"/>
      </svg>
    </a>

    <?php if ($usuario): ?>
      <div class="user-greeting">
        <span>Hola, <?= htmlspecialchars($usuario['nombre']) ?> 👋</span>
        <a href="/J_S25_Tienda_Online/tienda_login_php/logout.php" class="logout-link" title="Cerrar sesión">Cerrar sesión</a>
      </div>
    <?php else: ?>
      <a href="/J_S25_Tienda_Online/tienda_login_php/login.php" class="icon-link" title="Usuario" id="userLoginLink">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
          <circle cx="12" cy="8" r="4"/><path d="M4 21v-1a7 7 0 0 1 14 0v1"/>
        </svg>
      </a>
    <?php endif; ?>

    <?php
      $count = 0;
      if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
          $count += $item['cantidad'] ?? 1;
        }
      }
    ?>
    <a href="/J_S25_Tienda_Online/tienda_login_php/carrito.php" class="icon-link" title="Carrito" aria-label="Carrito">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
      </svg>
      <?php if ($count > 0): ?>
        <span class="cart-count"><?= $count ?></span>
      <?php endif; ?>
    </a>

    <a href="#ayuda" class="help-link">¿Qué necesitas?</a>
  </div>
</header>

<!-- Offcanvas lateral -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menú</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>
  <div class="offcanvas-body">
    <nav class="d-flex flex-column">
      <a href="pulseras.php" class="mb-2">Pulseras</a>
      <a href="collares.php" class="mb-2">Collares</a>
      <a href="brazaletes.php" class="mb-2">Brazaletes</a>
      <a href="anillos.php" class="mb-2">Anillos</a>
      <a href="contactame.php" class="mb-2">Contáctanos</a>
    </nav>
  </div>
</div>
