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