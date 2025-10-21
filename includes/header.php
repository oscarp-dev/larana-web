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

  <!-- Estilos globales -->
  <link rel="stylesheet" href="/J_S25_Tienda_Online/style.css">

  <!-- Estilos de producto (solo si estás en la carpeta productos) -->
  <?php 
  $rutaActual = $_SERVER['PHP_SELF'];
  if (strpos($rutaActual, '/productos/') !== false): ?>
    <link rel="stylesheet" href="/J_S25_Tienda_Online/productos/producto.css">
  <?php endif; ?>
</head>
<body>
  
<header class="main-header">
  <div class="header-left">
    <nav class="top-nav">
      <a href="pulseras.php">Pulseras</a>
      <a href="collares.php">Collares</a>
      <a href="brazaletes.php">Brazaletes</a>
      <a href="anillos.php">Anillos</a>
      <a href="contactame.php">Contáctanos</a>
    </nav>
  </div>

  <div class="header-center">
    <a href="/J_S25_Tienda_Online/index.php#hero" class="brand" aria-label="LARANA JEWELRY">LARANA JEWELRY</a>
  </div>

  <div class="header-right">
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

    <a href="#" class="icon-link" title="Carrito" aria-label="Carrito">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
      </svg>
    </a>

    <a href="#ayuda" class="help-link">¿Qué necesitas?</a>
  </div>
</header>
