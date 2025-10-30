<footer class="footer">
  <div class="footer-inner">
    <div class="footer-left">
      <p>&copy; <?= date('Y'); ?> <span>LARANA JEWELRY</span> · Todos los derechos reservados</p>
    </div>

    <div class="footer-links">
      <a href="/index.php#productos">Colección</a>
      <a href="/index.php#historia">Nuestra historia</a>
      <a href="../tienda_login_php/register.php">Registro</a>
    </div>
  </div>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const userLoginLink = document.getElementById("userLoginLink");
    if (userLoginLink) {
      userLoginLink.addEventListener("click", e => {
        e.preventDefault();
        window.open("../tienda_login_php/login.php", "_blank"); // <-- ruta absoluta
      });
    }
  });
</script>

<script src=/js/aniadir_carrito.js"></script> <!-- <-- ruta absoluta -->
</body>
</html>
