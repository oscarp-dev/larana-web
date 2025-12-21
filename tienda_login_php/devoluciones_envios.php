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
        --gris-claro: #ffffffff;
    }

    .envios-page {
        padding: 80px 0;
        background-color: var(--gris-claro);
    }

    .envios-page .container-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 40px;
        text-align: center;
    }

    .envios-header {
        margin-bottom: 60px;
    }

    .envios-header .page-title {
        font-family: var(--font-heading);
        font-size: 3.5rem;
        color: var(--negro); 
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
    }

    .envios-header .page-title::after {
        content: '';
        display: block;
        width: 30%;
        height: 4px;
        background-color: var(--dorado);
        margin: 10px auto 0 auto;
        border-radius: 2px;
    }
    
    .envios-header .page-subtitle {
        font-family: var(--font-general);
        color: #666;
        font-size: 1.1rem;
        font-weight: 300;
    }

    /* ESTILO DE BLOQUES DE INFORMACIÓN */
    .seccion-envios, .seccion-devoluciones {
        background-color: var(--blanco);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        margin-bottom: 50px;
        text-align: left;
    }
    
    /* ESTILO DE TÍTULOS CON ICONO CENTRADO */
    .seccion-envios h2, .seccion-devoluciones h2 {
        font-family: var(--font-heading);
        color: var(--dorado);
        font-size: 2.5rem;
        margin-bottom: 30px;
        text-align: center;
        display: flex; /* Para alinear icono y texto */
        justify-content: center;
        align-items: center;
    }
    
    .seccion-envios h2 i, .seccion-devoluciones h2 i {
        margin-right: 15px;
        font-size: 1.8rem;
    }

    .grid-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 30px;
    }

    .info-card {
        padding: 25px;
        border-radius: 8px;
        background-color: #ffffff;
        border: 1px solid #eee;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center; /* CENTRADO DE CONTENIDO */
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .info-card i {
        font-size: 2.2rem;
        color: var(--dorado);
        margin-bottom: 15px;
    }

    .info-card h3 {
        font-family: var(--font-general);
        font-size: 1.25rem;
        color: var(--negro);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .info-card p {
        font-family: var(--font-general);
        font-size: 0.95rem;
        line-height: 1.6;
        color: #666;
    }
    
    .punto-importante {
        padding: 20px 0;
        margin-top: 30px;
        border-top: 2px solid var(--gris-claro);
        text-align: center;
    }
    
    .punto-importante p {
        font-family: var(--font-general);
        font-weight: 600;
        color: var(--negro);
        font-size: 1rem;
        margin: 0;
    }
    
    .punto-importante span {
        color: var(--dorado);
        font-weight: 700;
    }
    
    .guia-pasos {
        list-style: none;
        padding-left: 0;
        counter-reset: dev-step;
        text-align: left; /* Aseguramos que los pasos no estén centrados */
    }
    
    .guia-pasos li {
        margin-bottom: 25px;
        padding-left: 50px;
        position: relative;
        font-family: var(--font-general);
        line-height: 1.6;
        color: #444;
    }

    .guia-pasos li::before {
        counter-increment: dev-step;
        content: counter(dev-step);
        position: absolute;
        left: 0;
        top: 0;
        background-color: var(--dorado);
        color: var(--blanco);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-weight: 700;
        font-family: var(--font-heading);
    }
    
    @media (max-width: 900px) {
        .grid-info {
            grid-template-columns: 1fr;
        }
        .seccion-envios, .seccion-devoluciones {
            padding: 30px 20px;
        }
    }
</style>

<main class="main-content envios-page">
    <div class="container-page">
        <header class="envios-header">
            <h1 class="page-title">Envíos y Devoluciones</h1>
            <p class="page-subtitle">Información clave para que su experiencia de compra sea tan fluida como la seda.</p>
        </header>

        <section class="seccion-envios">
            <h2><i class="fas fa-truck"></i> Información de Envíos</h2>
            
            <div class="grid-info">
                <div class="info-card">
                    <i class="fas fa-shipping-fast"></i>
                    <h3>Tiempo de Procesamiento</h3>
                    <p>Todos los pedidos se procesan y preparan en nuestro taller en un plazo de 24 a 48 horas laborables. Las joyas personalizadas pueden tardar hasta 72 horas.</p>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-box"></i>
                    <h3>Costes y Opciones</h3>
                    <p>Ofrecemos envío estándar gratuito en todos los pedidos superiores a 100€. Para pedidos inferiores, el coste es de 4,95€. También disponemos de envío exprés.</p>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Seguimiento y Entrega</h3>
                    <p>Una vez enviado, recibirá un correo electrónico con el número de seguimiento. El tiempo de entrega habitual en España es de 2 a 4 días laborables.</p>
                </div>
            </div>
            
            <div class="punto-importante">
                <p>Recordatorio: Asegúrese de que su dirección de envío sea correcta para evitar retrasos. Para envíos internacionales, <span>consulte tarifas y plazos en la cesta de compra.</span></p>
            </div>
        </section>

        <section class="seccion-devoluciones">
            <h2><i class="fas fa-reply-all"></i> Política de Devoluciones</h2>
            
            <div class="grid-info">
                <div class="info-card">
                    <i class="fas fa-undo"></i>
                    <h3>Plazo de Devolución</h3>
                    <p>Dispone de 30 días naturales desde la recepción de su joya para solicitar una devolución o un cambio de talla/modelo.</p>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h3>Condiciones del Producto</h3>
                    <p>Las joyas deben estar sin usar, en su embalaje original y con el certificado de autenticidad. No se aceptan productos dañados o personalizados.</p>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-exchange-alt"></i>
                    <h3>Reembolso</h3>
                    <p>El reembolso se procesará en un plazo de 7 días laborables tras la inspección de la joya devuelta. El importe se abonará al método de pago original.</p>
                </div>
            </div>
            
            <div style="margin-top: 40px;">
                <h3 style="font-family: var(--font-heading); color: var(--negro); font-size: 1.5rem; margin-bottom: 20px; text-align: center;">Guía Rápida: Cómo Devolver un Artículo</h3>
                <ul class="guia-pasos">
                    <li>
                        <strong>Paso 1: Contacto.</strong> Envíe un email a info@laranajewelry.com indicando su número de pedido y el motivo de la devolución.
                    </li>
                    <li>
                        <strong>Paso 2: Embalaje.</strong> Prepare la joya en su caja original y asegúrese de que esté bien protegida para el transporte.
                    </li>
                    <li>
                        <strong>Paso 3: Envío.</strong> Enviaremos una etiqueta de devolución (si aplica) o le proporcionaremos la dirección de nuestro taller. Una vez lo recibamos, procederemos a la inspección y reembolso.
                    </li>
                </ul>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>