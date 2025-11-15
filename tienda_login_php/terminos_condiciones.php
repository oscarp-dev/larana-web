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

    .terminos-page {
        padding: 80px 0;
        background-color: var(--gris-claro);
    }

    .terminos-page .container-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 40px;
        text-align: left;
        background-color: var(--blanco);
        border-radius: 10px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        padding: 50px;
    }

    .terminos-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .terminos-header .page-title {
        font-family: var(--font-heading);
        font-size: 3.2rem;
        color: var(--negro); 
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .terminos-header .page-title::after {
        content: '';
        display: block;
        width: 40%;
        height: 4px;
        background-color: var(--dorado);
        margin: 10px auto 0 auto;
        border-radius: 2px;
    }

    .terminos-content h2 {
        font-family: var(--font-heading);
        color: var(--dorado);
        font-size: 2rem;
        margin-top: 40px;
        margin-bottom: 20px;
        padding-bottom: 5px;
        position: relative;
    }

    .terminos-content h3 {
        font-family: var(--font-general);
        color: var(--negro);
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 10px;
    }

    .terminos-content p {
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
        padding-left: 0; 
        position: relative;
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

<main class="main-content terminos-page">
    <div class="container-page">
        <header class="terminos-header">
            <h1 class="page-title">Términos y Condiciones</h1>
        </header>

        <section class="terminos-content">

            <h2>1. Aceptación de los Términos</h2>
            <p>
                Al acceder y utilizar el sitio web de LARANA JEWELRY (en adelante, "La Tienda"), usted acepta y se compromete a cumplir con los presentes Términos y Condiciones. Si no está de acuerdo con alguna parte de los términos, debe abstenerse de utilizar nuestros servicios.
            </p>

            <h2>2. Condiciones de Compra</h2>
            <h3>2.1 Precios y Pagos</h3>
            <p>
                Los precios de los productos están expresados en Euros (€) e incluyen el Impuesto sobre el Valor Añadido (IVA) aplicable en España. Nos reservamos el derecho de modificar los precios en cualquier momento sin previo aviso. La Tienda acepta diversas formas de pago, las cuales se detallan durante el proceso de compra.
            </p>

            <h3>2.2 Disponibilidad de Productos</h3>
            <p>
                Todos los pedidos de productos están sujetos a la disponibilidad de los mismos. En caso de no disponibilidad, se le informará y se procederá al reembolso total de cualquier cantidad que haya podido abonar.
            </p>

            <h3>2.3 Proceso de Envío</h3>
            <p>
                El tiempo de entrega estimado y los costes de envío se especifican en el momento de la compra. La Tienda no se hace responsable de los retrasos causados por la empresa de transporte o por causas de fuerza mayor.
            </p>
            
            <h2>3. Propiedad Intelectual</h2>
            <p>
                Todo el contenido del sitio web, incluyendo textos, gráficos, logotipos, imágenes y diseños de joyería, es propiedad de LARANA JEWELRY o de sus proveedores de contenido y está protegido por las leyes de propiedad intelectual e industrial. Queda estrictamente prohibida su reproducción, distribución o modificación sin consentimiento expreso por escrito.
            </p>

            <h2>4. Devoluciones y Cambios</h2>
            <p>
                El Cliente dispone de un plazo de 14 días naturales, contados desde la fecha de recepción del pedido, para ejercer su derecho de desistimiento. Las joyas deben devolverse en perfecto estado, sin haber sido usadas, en su embalaje original y con el certificado de garantía adjunto.
            </p>
            <ul class="lista-elegante">
                <li>El coste de la devolución correrá a cargo del Cliente, salvo en casos de defecto o error en el envío.</li>
                <li>Los productos personalizados o hechos a medida no admiten devolución ni cambio.</li>
            </ul>

            <h2>5. Responsabilidad</h2>
            <p>
                La Tienda no será responsable de las interrupciones o errores en el acceso o funcionamiento del sitio web, ni de los daños directos o indirectos que puedan derivarse de su uso. Nuestra responsabilidad máxima por cualquier daño o pérdida se limitará al precio de compra del producto o servicio.
            </p>
            
            <h2>6. Ley Aplicable y Jurisdicción</h2>
            <p>
                Los presentes Términos y Condiciones se rigen e interpretan de acuerdo con la legislación española. Para la resolución de cualquier conflicto o disputa que pueda surgir, las partes se someterán a la jurisdicción de los Juzgados y Tribunales de la ciudad de Madrid.
            </p>

            <span class="ultima-actualizacion">Última actualización: 15 de Noviembre de 2025</span>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>