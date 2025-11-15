<style>
    /* * Estilos críticos para asegurar que el footer se ancle al fondo de la página. */
    html {
        height: 100%; 
    }
    body {
        display: flex; 
        flex-direction: column; 
        min-height: 100vh; 
        
        /* 🎨 CORRECCIÓN DEL COLOR DE FONDO: BLANCO */
        background-color: #ffffff; 
        
        /* Asegura que no haya margen externo que rompa el 100% */
        margin: 0; 
    }
    
    /* * Clases que envuelven el CONTENIDO PRINCIPAL */
    .page-content-wrapper {
        flex-grow: 1; /* Esto empuja el footer hacia abajo */
        margin-bottom: 0; 
        padding-bottom: 50px; 
    }

    /* * Corrección de Ancho del Footer */
    .footer {
        width: 100%; 
        clear: both;
        margin: 0;
        padding-left: 0;
        padding-right: 0;
    }
    
    /* Asegura que el contenedor interno no se vea limitado */
    .footer .container-page {
        max-width: 1200px; 
        margin: 0 auto;
        padding-left: 10%; 
        padding-right: 10%;
    }
</style>
<footer class="footer">
    <div class="footer-inner container-page">
        
        <div class="footer-column footer-nav">
            <h4 class="footer-heading">Explora LARANA</h4>
            <a href="/J_S25_Tienda_Online/tienda_login_php/coleccion.php">Colección</a>
            <a href="/J_S25_Tienda_Online/tienda_login_php/historia.php">Nuestra Historia</a>
            <a href="/J_S25_Tienda_Online/tienda_login_php/artesania.php">Artesanía</a>
            <a href="/J_S25_Tienda_Online/tienda_login_php/register.php">Crear Cuenta</a>
        </div>

        <div class="footer-column footer-legal">
            <h4 class="footer-heading">Información Legal</h4>
            <a href="/J_S25_Tienda_Online/tienda_login_php/politica_privacidad.php">Política de Privacidad</a>
            <a href="/J_S25_Tienda_Online/tienda_login_php/terminos_condiciones.php">Términos y Condiciones</a>
            <a href="/J_S25_Tienda_Online/tienda_login_php/devoluciones_envios.php">Devoluciones y Envíos</a>
            <a href="/J_S25_Tienda_Online/tienda_login_php/politica_cookies.php">Política de Cookies</a> 
        </div>

        <div class="footer-column footer-contact">
            <h4 class="footer-heading">Contacto</h4>
            <p>Email: info@laranajewelry.com</p>
            <p>Teléfono: +34 958 12 34 56</p>
        <div class="social-links">
            <a href="/J_S25_Tienda_Online/" aria-label="Instagram"><i class="fa-brands fa-square-instagram"></i></a>
            <a href="/J_S25_Tienda_Online/" aria-label="Facebook"><i class="fa-brands fa-facebook-square"></i></a>
            <a href="/J_S25_Tienda_Online/" aria-label="Pinterest"><i class="fa-brands fa-pinterest"></i></a>
        </div>
</div>

    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y'); ?> LARANA JEWELRY. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>