<?php
// Iniciar sesión para detectar si hay usuario logueado
session_start();
$usuario = $_SESSION['usuario'] ?? null;
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
</head>
<body>

  <!-- HEADER -->
  <header class="main-header">
    <div class="header-left">
      <nav class="top-nav">
        <a href="#productos">Pulseras</a>
        <a href="#categorias">Collares</a>
        <a href="#categorias">Brazaletes</a>
        <a href="#categorias">Anillos</a>
        <a href="#contacto">Contáctanos</a>
      </nav>
    </div>

    <div class="header-center">
      <a href="#hero" class="brand" aria-label="LARANA JEWELRY">LARANA JEWELRY</a>
    </div>

    <div class="header-right">
      <a href="#buscar" class="icon-link" title="Buscar" aria-label="Buscar">
        <!-- Icono de búsqueda -->
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"/><path d="M21 21l-3.5-3.5"/>
        </svg>
      </a>

      <?php if ($usuario): ?>
        <!-- 👋 Usuario logueado -->
        <div class="user-greeting">
          <span>Hola, <?= htmlspecialchars($usuario['nombre']) ?> 👋</span>
          <a href="tienda_login_php/logout.php" class="logout-link" title="Cerrar sesión">Cerrar sesión</a>
        </div>
      <?php else: ?>
        <!-- 🔐 Login -->
        <a href="tienda_login_php/login.php" class="icon-link" title="Usuario" id="userLoginLink">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4"/><path d="M4 21v-1a7 7 0 0 1 14 0v1"/>
          </svg>
        </a>
      <?php endif; ?>

      <a href="#carrito" class="icon-link" title="Carrito" aria-label="Carrito">
        <!-- Icono de carrito -->
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#111" stroke-width="1.5" viewBox="0 0 24 24">
          <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
      </a>

      <a href="#ayuda" class="help-link">¿Qué necesitas?</a>
    </div>
  </header>

  <!-- HERO -->
  <section id="hero" class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h2>Joyas que cuentan tu historia</h2>
      <a href="#productos" class="btn">Descubrir joyas</a>
    </div>
  </section>

  <!-- NUEVA COLECCIÓN -->
  <section id="productos" class="nueva-coleccion container">
    <h2>Nueva colección</h2>
    <div class="grid-productos">
      <article class="producto">
        <div class="producto-media"><img src="images/producto2.jpg" alt="Pulsera Dorada"></div>
        <h3>Pulsera Dorada</h3>
        <span class="precio">€120</span>
        <button class="btn-line" aria-label="Comprar Pulsera Dorada">Comprar</button>
      </article>
      <article class="producto">
        <div class="producto-media"><img src="images/producto3.jpg" alt="Collar Elegante"></div>
        <h3>Collar Elegante</h3>
        <span class="precio">€150</span>
        <button class="btn-line" aria-label="Comprar Collar Elegante">Comprar</button>
      </article>
      <article class="producto">
        <div class="producto-media"><img src="images/producto1.jpg" alt="Anillo Minimal"></div>
        <h3>Anillo Minimal</h3>
        <span class="precio">€90</span>
        <a href="productos/anillo-minimal.php" class="btn-line" aria-label="Ver detalles del Anillo Minimal">
    Comprar
  </a>
      </article>
      <article class="producto">
        <div class="producto-media"><img src="images/producto4.jpg" alt="Pendientes Clásicos"></div>
        <h3>Pendientes Clásicos</h3>
        <span class="precio">€110</span>
        <button class="btn-line" aria-label="Comprar Pendientes Clásicos">Comprar</button>
      </article>
    </div>
    <a href="#productos" class="btn-dark">Ver todos los productos</a>
  </section>

  <!-- HISTORIA -->
  <section id="historia" class="historia">
    <div class="container historia-inner">
      <div class="historia-img">
        <img src="images/historia.jpg" alt="Sobre LARANA JEWELRY">
      </div>
      <div class="historia-texto">
        <h2>Joyas con esencia, hechas para durar</h2>
        <p>
          Cada pieza se diseña para que te acompañe en los instantes que importan y sea
          el detalle que personaliza tu estilo. Nuestro taller cuida los materiales al detalle.
        </p>
        <a href="#historia" class="btn">Nuestra historia</a>
      </div>
    </div>
  </section>

  <!-- CATEGORÍAS -->
  <section id="categorias" class="categorias container">
    <h2>Categorías</h2>
    <div class="grid-categorias">
      <a class="categoria" href="#productos">
        <div class="cat-media"><img src="images/pendientes.jpg" alt="Pendientes"></div>
        <p>Pendientes</p>
      </a>
      <a class="categoria" href="#productos">
        <div class="cat-media"><img src="images/collares.jpg" alt="Collares"></div>
        <p>Collares</p>
      </a>
      <a class="categoria" href="#productos">
        <div class="cat-media"><img src="images/brazaletes.jpg" alt="Brazaletes"></div>
        <p>Brazaletes</p>
      </a>
      <a class="categoria" href="#productos">
        <div class="cat-media"><img src="images/anillos.jpg" alt="Anillos"></div>
        <p>Anillos</p>
      </a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer id="contacto" class="footer">
    <div class="container footer-inner">
      <p>© 2025 LARANA JEWELRY · Todos los derechos reservados</p>
      <nav class="footer-links">
        <a href="#productos">Colección</a>
        <a href="#historia">Nuestra historia</a>
        <a href="#registro">Registro</a>
      </nav>
    </div>
  </footer>

  <!-- ✅ Script al final -->
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const userLoginLink = document.getElementById("userLoginLink");
    if (userLoginLink) {
      userLoginLink.addEventListener("click", e => {
        e.preventDefault();
        window.open("tienda_login_php/login.php", "_blank");
      });
    }
  });
  </script>

</body>
</html>
