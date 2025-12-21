<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db_connect.php';

include __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --dorado: #b38f53;
        --negro: #333;
        --blanco: #fff;
        --gris-claro: #f8f8f8;
        --gris-medio: #ddd;
    }

    .cookies-page {
        padding: 80px 0;
        background-color: var(--gris-claro);
    }

    .cookies-page .container-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 40px;
        text-align: left;
        background-color: var(--blanco);
        border-radius: 10px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        padding: 50px;
    }

    .cookies-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .cookies-header .page-title {
        font-family: var(--font-heading);
        font-size: 3.2rem;
        color: var(--negro); 
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .cookies-header .page-title i {
        color: var(--dorado);
        margin-right: 15px;
    }

    .cookies-header .page-title::after {
        content: '';
        display: block;
        width: 40%;
        height: 4px;
        background-color: var(--dorado);
        margin: 10px auto 0 auto;
        border-radius: 2px;
    }
    
    .cookies-content h2 {
        font-family: var(--font-heading);
        color: var(--dorado);
        font-size: 2rem;
        margin-top: 40px;
        margin-bottom: 20px;
        padding-bottom: 5px;
        position: relative;
        text-align: left;
    }

    .cookies-content h3 {
        font-family: var(--font-general);
        color: var(--negro);
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 30px;
        margin-bottom: 15px;
        padding-bottom: 5px;
        border-bottom: 2px solid var(--gris-claro);
    }

    .cookies-content p {
        font-family: var(--font-general);
        font-size: 1rem;
        line-height: 1.7;
        color: #555;
        margin-bottom: 15px;
    }
    
    .cookies-content strong {
        color: var(--negro);
    }

    /* ESTILO DE BLOQUES DE TIPO DE COOKIE (TARJETAS) PARA DISPOSICIÓN 2x2 */
    .cookie-type-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-top: 30px;
        margin-bottom: 40px;
    }

    .cookie-type-card {
        background-color: var(--gris-claro);
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: left;
    }

    .cookie-type-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .cookie-type-card i {
        font-size: 2.2rem;
        color: var(--dorado);
        margin-bottom: 15px;
        float: left;
        margin-right: 15px;
    }

    .cookie-type-card h3 {
        font-family: var(--font-general);
        color: var(--negro);
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 0;
        margin-bottom: 10px;
        line-height: 1.2;
        overflow: hidden;
    }

    .cookie-type-card p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #666;
        clear: both;
    }
    
    /* ESTILO SECCIÓN 3: TARJETAS DE NAVEGADORES (DISPOSICIÓN 3x2) */
    .navegadores-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }
    
    .navegadores-card {
        background-color: var(--blanco);
        border: 2px solid var(--gris-claro);
        border-left: 5px solid var(--dorado);
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: background-color 0.2s;
    }
    
    .navegadores-card:hover {
        background-color: #fcfcfc;
    }

    .navegadores-card header { 
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .navegadores-card i.fab,
    .navegadores-card i.fas {
        color: var(--dorado); 
        margin-right: 10px;
        font-size: 1.3em;
        width: 25px;
        text-align: center;
    }

    .navegadores-card span {
        font-family: var(--font-general);
        font-weight: 700;
        color: var(--negro);
        line-height: 1.2;
    }
    
    .navegadores-card p {
        font-size: 0.9rem;
        margin-top: 5px;
        padding-left: 0;
        color: #777;
        line-height: 1.5;
    }
    
    .navegadores-card p strong {
        color: var(--negro);
        font-weight: 400;
    }
    
    .navegadores-card p i.fas.fa-angle-right {
        color: var(--dorado); 
        font-size: 0.9em;
        margin: 0 3px; /* Reducimos el margen de 5px a 3px */
    }
    
    /* Ajuste específico para el icono del ordenador en 'Otros Navegadores' */
    .navegadores-card:last-child header i {
        margin-right: 10px;
    }


    /* ESTILOS DE TABLA MEJORADOS (BORDES REDONDEADOS) */
    .cookies-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 30px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .cookies-table th, .cookies-table td {
        padding: 12px 15px;
        border: none;
        font-family: var(--font-general);
        font-size: 0.95rem;
        text-align: left;
    }

    .cookies-table thead th {
        background-color: var(--dorado);
        color: var(--blanco);
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .cookies-table tbody td {
        background-color: var(--blanco);
        border-bottom: 1px solid #eee;
        color: #666;
    }

    .cookies-table tbody tr:nth-child(even) td {
        background-color: #fcfcfc;
    }

    .cookies-table tbody tr:last-child td {
        border-bottom: none;
    }

    .ultima-actualizacion {
        display: block;
        text-align: center;
        font-style: italic;
        color: #aaa;
        margin-top: 50px;
        font-size: 0.9rem;
    }

    /* MEDIA QUERIES PARA RESPONSIVE */
    @media (max-width: 900px) {
        .navegadores-grid {
            grid-template-columns: repeat(2, 1fr); 
        }
    }

    @media (max-width: 768px) {
        .cookies-page .container-page {
            padding: 30px;
        }
        .cookie-type-grid, .navegadores-grid {
            grid-template-columns: 1fr; 
        }
    }
</style>

<main class="main-content cookies-page">
    <div class="container-page">
        <header class="cookies-header">
            <h1 class="page-title"><i class="fas fa-cookie-bite"></i> Política de Cookies</h1>
        </header>

        <section class="cookies-content">

            <h2>1. ¿Qué son las Cookies?</h2>
            <p>
                Una cookie es un pequeño archivo de texto que se almacena en su navegador cuando visita nuestro sitio web. Las cookies permiten a LARANA JEWELRY recordar información sobre su visita, como el idioma preferido, el contenido de su cesta de la compra y la configuración de sesión, para facilitar y personalizar su experiencia de navegación.
            </p>

            <h2>2. Tipos de Cookies que Utilizamos</h2>
            <p>
                Utilizamos cookies propias y de terceros con diferentes finalidades:
            </p>
            
            <div class="cookie-type-grid">
                <div class="cookie-type-card">
                    <i class="fas fa-cog"></i>
                    <h3>Cookies Técnicas o Necesarias</h3>
                    <p>
                        Estas cookies son fundamentales para el funcionamiento básico del sitio web. Permiten la navegación, el acceso a áreas seguras, la gestión de la sesión y el mantenimiento de la cesta de la compra. Sin ellas, el sitio no podría funcionar correctamente.
                    </p>
                </div>
                
                <div class="cookie-type-card">
                    <i class="fas fa-magic"></i>
                    <h3>Cookies de Funcionalidad</h3>
                    <p>
                        Permiten recordar sus preferencias (como la moneda o el idioma) para ofrecerle una experiencia más personalizada y adaptada a sus elecciones y facilitarle la navegación en futuras visitas.
                    </p>
                </div>

                <div class="cookie-type-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Cookies de Análisis o Rendimiento</h3>
                    <p>
                        Permiten contar el número de visitantes y analizar estadísticamente el uso que hacen los usuarios de nuestro sitio web y productos. Esta información nos ayuda a mejorar la forma en que funciona la tienda.
                    </p>
                </div>
                
                <div class="cookie-type-card">
                    <i class="fas fa-bullhorn"></i>
                    <h3>Cookies de Publicidad o Marketing</h3>
                    <p>
                        Se utilizan para crear un perfil de sus intereses y mostrar anuncios relevantes para usted en otros sitios web, basándose en su navegación, sus intereses y las páginas que ha visitado en nuestra tienda.
                    </p>
                </div>
            </div>
            
            <h2>3. Gestión de Cookies</h2>
            <p>
                Usted tiene el control sobre la instalación de cookies. Puede configurarlas, bloquearlas o eliminarlas en cualquier momento. A continuación, le ofrecemos una guía rápida sobre cómo puede gestionar las cookies desde los principales navegadores:
            </p>
            
            <div class="navegadores-grid">
                <div class="navegadores-card">
                    <header>
                        <i class="fab fa-chrome"></i> <span>Google Chrome</span>
                    </header>
                    <p>Configuración <i class="fas fa-angle-right"></i> Mostrar opciones avanzadas <i class="fas fa-angle-right"></i> Privacidad <i class="fas fa-angle-right"></i> Configuración de contenido.</p>
                </div>
                
                <div class="navegadores-card">
                    <header>
                        <i class="fab fa-firefox-browser"></i> <span>Mozilla Firefox</span>
                    </header>
                    <p>Herramientas <i class="fas fa-angle-right"></i> Opciones <i class="fas fa-angle-right"></i> Privacidad <i class="fas fa-angle-right"></i> Historial <i class="fas fa-angle-right"></i> Configuración Personalizada.</p>
                </div>

                <div class="navegadores-card">
                    <header>
                        <i class="fab fa-safari"></i> <span>Safari</span>
                    </header>
                    <p>Preferencias <i class="fas fa-angle-right"></i> Seguridad. También puede gestionar en el panel de Privacidad.</p>
                </div>

                <div class="navegadores-card">
                    <header>
                        <i class="fab fa-edge"></i> <span>Microsoft Edge</span>
                    </header>
                    <p>Configuración <i class="fas fa-angle-right"></i> Privacidad, búsqueda y servicios <i class="fas fa-angle-right"></i> Borrar datos de navegación.</p>
                </div>
                
                <div class="navegadores-card">
                    <header>
                        <i class="fab fa-opera"></i> <span>Opera</span>
                    </header>
                    <p>Configuración <i class="fas fa-angle-right"></i> Opciones <i class="fas fa-angle-right"></i> Privacidad y seguridad <i class="fas fa-angle-right"></i> Cookies.</p>
                </div>
                
                <div class="navegadores-card">
                    <header>
                        <i class="fas fa-desktop"></i> <span>Otros Navegadores</span>
                    </header>
                    <p>Consulte la documentación de ayuda del navegador que esté utilizando para obtener instrucciones precisas.</p>
                </div>
            </div>

            <h2>4. Detalle de Cookies de Terceros</h2>
            <p>
                A continuación, detallamos algunas de las principales cookies de terceros utilizadas en nuestra web:
            </p>
            <table class="cookies-table">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Cookie</th>
                        <th>Finalidad</th>
                        <th>Duración</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Google Analytics</td>
                        <td>_ga, _gid</td>
                        <td>Recopilación de información estadística sobre el tráfico web y la fuente de las visitas.</td>
                        <td>2 años / 24 horas</td>
                    </tr>
                    <tr>
                        <td>Facebook / Meta</td>
                        <td>_fbp, fr</td>
                        <td>Usada por Facebook para ofrecer publicidad relevante a los usuarios.</td>
                        <td>3 meses</td>
                    </tr>
                    <tr>
                        <td>LARANA JEWELRY (Propia)</td>
                        <td>session_id</td>
                        <td>Necesaria para mantener la sesión de usuario activa y la cesta de la compra.</td>
                        <td>Fin de la sesión</td>
                    </tr>
                </tbody>
            </table>

            <span class="ultima-actualizacion">Última actualización: 15 de Noviembre de 2025</span>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>