<?php
// Iniciar sesión para detectar si hay usuario logueado

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
</head>
<body>

  <!-- HEADER -->
  <?php include __DIR__ . '/includes/header.php'; ?>


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
        <form action="/J_S25_Tienda_Online/tienda_login_php/carrito.php" method="POST">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="nombre" value="Pulsera Dorada">
          <input type="hidden" name="precio" value="120">
          <button type="submit" name="add_to_cart" class="btn-line">🛒 Añadir al carrito</button>
        </form>
      </article>
      <article class="producto">
        <div class="producto-media"><img src="images/producto3.jpg" alt="Collar Elegante"></div>
        <h3>Collar Elegante</h3>
        <span class="precio">€150</span>
        <button class="btn-line" aria-label="Comprar Collar Elegante">Comprar</button>
        <form action="/J_S25_Tienda_Online/tienda_login_php/carrito.php" method="POST">
          <input type="hidden" name="id" value="2">
          <input type="hidden" name="nombre" value="Collar Elegante">
          <input type="hidden" name="precio" value="150">
          <button type="submit" name="add_to_cart" class="btn-line">🛒 Añadir al carrito</button>
        </form>
      </article>
      <article class="producto">
        <div class="producto-media"><img src="images/producto1.jpg" alt="Anillo Minimal"></div>
        <h3>Anillo Minimal</h3>
        <span class="precio">€90</span>
        <a href="productos/anillo-minimal.php" class="btn-line" aria-label="Ver detalles del Anillo Minimal">
          Comprar
        </a>
        <form action="/J_S25_Tienda_Online/tienda_login_php/carrito.php" method="POST">
          <input type="hidden" name="id" value="3">
          <input type="hidden" name="nombre" value="Anillo Minimal">
          <input type="hidden" name="precio" value="90">
          <button type="submit" name="add_to_cart" class="btn-line">🛒 Añadir al carrito</button>
        </form>
      </article>
      <article class="producto">
        <div class="producto-media"><img src="images/producto4.jpg" alt="Pendientes Clásicos"></div>
        <h3>Pendientes Clásicos</h3>
        <span class="precio">€110</span>
        <button class="btn-line" aria-label="Comprar Pendientes Clásicos">Comprar</button>
        <form action="/J_S25_Tienda_Online/tienda_login_php/carrito.php" method="POST">
          <input type="hidden" name="id" value="4">
          <input type="hidden" name="nombre" value="Pendientes Clásicos">
          <input type="hidden" name="precio" value="110">
          <button type="submit" name="add_to_cart" class="btn-line">🛒 Añadir al carrito</button>
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

  <!-- NUEVAS SECCIONES -->
  <section id="opciones" class="opciones container">
    <h2>Explora nuestras secciones</h2>
    <div class="grid-opciones">
      <a class="btn-opcion" href="pulseras.php">Pulseras</a>
      <a class="btn-opcion" href="collares.php">Collares</a>
      <a class="btn-opcion" href="brazaletes.php">Brazaletes</a>
      <a class="btn-opcion" href="anillos.php">Anillos</a>
      <a class="btn-opcion" href="contactame.php">Contáctame</a>
    </div>
  </section>

  
    <footer class="footer">
    <div class="footer-inner">
      <div class="footer-left">
        <p>&copy; <?= date('Y'); ?> <span>LARANA JEWELRY</span> · Todos los derechos reservados</p>
      </div>

      <div class="footer-links">
        <a href="/larana/index.php#productos">Colección</a>
        <a href="/larana/index.php#historia">Nuestra historia</a>
        <a href="/larana/tienda_login_php/registro.php">Registro</a>
      </div>
    </div>
  </footer>

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

    document.addEventListener("DOMContentLoaded", () => {
      const forms = document.querySelectorAll('form[action*="carrito.php"]');

      forms.forEach(form => {
        form.addEventListener("submit", async e => {
          e.preventDefault(); // evitar que abra carrito.php

          const formData = new FormData(form);
          formData.append("ajax", "1"); // marcar como AJAX

          try {
            const res = await fetch(form.action, {
              method: "POST",
              body: formData
            });
            const data = await res.json();

            if (data.ok) {
              // actualizar contador carrito (si hay en header)
              const cartCount = document.querySelector(".cart-count");
              if (cartCount) {
                cartCount.textContent = data.count;
              } else {
                // Si aún no existe, lo crea
                const cartIcon = document.querySelector('.icon-link[title="Ver carrito"]');
                if (cartIcon) {
                  const badge = document.createElement("span");
                  badge.className = "cart-count";
                  badge.textContent = data.count;
                  cartIcon.appendChild(badge);
                }
              }

              // animación o aviso visual
              const aviso = document.createElement("div");
              aviso.textContent = `🛒 ${data.nombre} añadido al carrito`;
              aviso.style.position = "fixed";
              aviso.style.bottom = "20px";
              aviso.style.right = "20px";
              aviso.style.background = "var(--dorado, #d4af37)";
              aviso.style.color = "#fff";
              aviso.style.padding = "12px 20px";
              aviso.style.borderRadius = "12px";
              aviso.style.boxShadow = "0 3px 10px rgba(0,0,0,0.15)";
              aviso.style.zIndex = "9999";
              aviso.style.transition = "opacity 0.6s ease";
              document.body.appendChild(aviso);

              setTimeout(() => {
                aviso.style.opacity = "0";
                setTimeout(() => aviso.remove(), 600);
              }, 1800);
            } else {
              alert("Error al añadir al carrito");
            }
          } catch (err) {
            console.error(err);
            alert("No se pudo conectar con el servidor.");
          }
        });
      });
    });
  </script>
</body>
</html>

