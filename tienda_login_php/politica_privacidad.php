<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db_connect.php';

include __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --dorado: #b38f53;
        --negro: #333;
        --blanco: #fff;
        --gris-claro: #f8f8f8;
    }

    .politica-page {
        padding: 80px 0;
        background-color: var(--gris-claro);
    }

    .politica-page .container-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 40px;
        text-align: left;
        background-color: var(--blanco);
        border-radius: 10px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        padding: 50px;
    }

    .politica-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .politica-header .page-title {
        font-family: var(--font-heading);
        font-size: 3.2rem;
        color: var(--negro); 
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .politica-header .page-title::after {
        content: '';
        display: block;
        width: 40%;
        height: 4px;
        background-color: var(--dorado);
        margin: 10px auto 0 auto;
        border-radius: 2px;
    }

    .politica-content h2 {
        font-family: var(--font-heading);
        color: var(--dorado);
        font-size: 2rem;
        margin-top: 40px;
        margin-bottom: 20px;
        padding-bottom: 5px;
        position: relative;
    }

    .politica-content h3 {
        font-family: var(--font-general);
        color: var(--negro);
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 10px;
    }

    .politica-content p {
        font-family: var(--font-general);
        font-size: 1rem;
        line-height: 1.7;
        color: #555;
        margin-bottom: 15px;
    }
    
    .lista-elegante {
        list-style: none;
        padding-left: 0;
        margin-top: 15px;
    }

    .lista-elegante li {
        font-family: var(--font-general);
        line-height: 1.8;
        color: #444;
        margin-bottom: 8px;
        padding-left: 25px;
        position: relative;
    }

    .lista-elegante li::before {
        content: '•'; 
        color: var(--dorado);
        font-size: 1.5em;
        line-height: 0;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    .ultima-actualizacion {
        display: block;
        text-align: center;
        font-style: italic;
        color: #aaa;
        margin-top: 50px;
        font-size: 0.9rem;
    }
</style>

<main class="main-content politica-page">
    <div class="container-page">
        <header class="politica-header">
            <h1 class="page-title">Política de Privacidad</h1>
        </header>

        <section class="politica-content">

            <h2>1. Responsable del Tratamiento</h2>
            <p>
                LARANA JEWELRY (en adelante, "La Tienda") con domicilio en Paseo de la Joyería, 45, 28001 Madrid y email de contacto info@laranajewelry.com, es la responsable del tratamiento de los datos personales de sus usuarios. Nos comprometemos a proteger su privacidad y a tratar su información personal con total transparencia y de acuerdo con la legislación vigente.
            </p>

            <h2>2. Datos que Recopilamos</h2>
            <p>
                Recopilamos la información estrictamente necesaria para ofrecerle la mejor experiencia de compra y gestionar sus pedidos:
            </p>
            <ul class="lista-elegante">
                <li>
                    <strong>Datos de Identificación y Contacto:</strong> Su nombre, apellidos, dirección de correo electrónico, dirección postal y número de teléfono. Son esenciales para la gestión de pedidos y la comunicación directa.
                </li>
                <li>
                    <strong>Datos de Transacción y Pago:</strong> Información relacionada con su método de pago. Tenga en cuenta que estos datos sensibles son procesados directamente por pasarelas de pago seguras (como Stripe o PayPal), y nosotros solo almacenamos un token de referencia si opta por guardar sus detalles de pago.
                </li>
                <li>
                    <strong>Datos de Navegación:</strong> Dirección IP, tipo de dispositivo, páginas visitadas y patrones de uso, recopilados mediante tecnologías como las cookies para mejorar continuamente la funcionalidad de nuestra web.
                </li>
            </ul>

            <h2>3. Finalidad del Tratamiento</h2>
            <p>
                Sus datos son tratados bajo rigurosos estándares de seguridad y se utilizan exclusivamente para los siguientes propósitos:
            </p>
            <ul class="lista-elegante">
                <li>Gestionar, procesar y cumplir con sus pedidos, incluyendo el envío y la notificación sobre el estado de la entrega.</li>
                <li>Ofrecer soporte al cliente, gestionar devoluciones y atender cualquier consulta o incidencia relacionada con su compra.</li>
                <li>Gestionar su cuenta personal, permitiendo un acceso más rápido y la consulta de su historial de pedidos.</li>
                <li>Enviar boletines de noticias, promociones y ofertas especiales, siempre y cuando haya dado su consentimiento explícito.</li>
                <li>Realizar análisis internos para optimizar la estructura de nuestra web, la oferta de productos y la experiencia de compra.</li>
            </ul>

            <h2>4. Base Legal para el Tratamiento</h2>
            <p>
                El procesamiento de sus datos se realiza con base en los siguientes fundamentos legales (RGPD):
            </p>
            <ul class="lista-elegante">
                <li>
                    <strong>Ejecución Contractual:</strong> El tratamiento es necesario para la formalización y cumplimiento del contrato de compraventa cuando usted realiza un pedido.
                </li>
                <li>
                    <strong>Consentimiento:</strong> Para el envío de comunicaciones de marketing o la instalación de cookies no esenciales, requerimos su consentimiento previo y expreso.
                </li>
                <li>
                    <strong>Interés Legítimo:</strong> Para mejorar la seguridad de la plataforma, prevenir el fraude y realizar análisis de negocio que beneficien la calidad del servicio.
                </li>
            </ul>

            <h2>5. Derechos del Usuario</h2>
            <p>
                Como usuario, usted tiene el control total sobre su información. Puede ejercer sus derechos de Acceso, Rectificación, Supresión, Oposición, Limitación del Tratamiento y Portabilidad (Derechos ARCO y demás). Para ejercer cualquiera de estos derechos, por favor, envíe su solicitud detallada a info@laranajewelry.com.
            </p>

            <span class="ultima-actualizacion">Última actualización: 15 de Noviembre de 2025</span>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>