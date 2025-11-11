<?php
// Iniciar sesión para detectar si hay usuario logueado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/tienda_login_php/db_connect.php';

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

  <!-- HEADER -->
  <?php include __DIR__ . '/includes/header.php'; ?>


  <!-- HERO -->
  <section id="hero" class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <p class="hero-subtitle">DESCUBRE LA NUEVA COLECCIÓN</p>
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
        <a href="tienda_login_php/historia.php" class="btn">Nuestra historia</a>
        </div>
    </div>
</section>

  <!-- CATEGORÍAS -->
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

  <!-- NUEVAS SECCIONES -->
  <section id="opciones" class="opciones container">
    <h2>Explora nuestras secciones</h2>
    <div class="grid-opciones">
      <a class="btn-opcion" href="categorias/categoria.php?categoria=Pulseras">Pulseras</a>
      <a class="btn-opcion" href="categorias/categoria.php?categoria=Collares">Collares</a>
      <a class="btn-opcion" href="categorias/categoria.php?categoria=Pendientes">Pendientes</a>
      <a class="btn-opcion" href="categorias/categoria.php?categoria=Anillos">Anillos</a>
      <a class="btn-opcion" href="categorias/contactame.php">Contáctanos</a>
    </div>
  </section>

<?php include __DIR__ . '/includes/footer.php'; ?>

