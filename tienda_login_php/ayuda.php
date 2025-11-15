<?php
include '../includes/header.php'; 
$base_url = '/J_S25_Tienda_Online'; 
?>

<style>
    .btn-dark-elegant {
        background-color: #b38f53;
        border-color: #b38f53;
        color: white !important; /* Texto blanco asegurado con !important */
        font-weight: 600;
        transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-dark-elegant:hover,
    .btn-dark-elegant:focus {
        background-color: #c6a664;
        border-color: #c6a664;
        color: white !important; /* Texto blanco en hover/focus asegurado con !important */
    }

    .help-header {
        background-color: #1a1a1a;
        color: white;
        padding: 80px 0; 
        text-align: center;
        margin-bottom: 50px;
    }
    .help-header h1 {
        font-weight: 500;
        font-size: 3rem; 
        margin-bottom: 15px;
        color: #fff; 
        text-transform: none; 
    }
    .help-header p {
        color: #e0e0e0; 
        font-size: 1.2rem; 
        line-height: 1.6;
        max-width: 700px; 
        margin: 0 auto; 
        font-weight: 400;
    }

    .help-section {
        padding: 50px 0;
        border-bottom: 1px solid #eee;
    }
    .help-section:last-child {
        border-bottom: none;
    }
    .help-section h2 {
        color: #b38f53; 
        font-weight: 700;
        margin-bottom: 40px;
        text-align: center;
        text-transform: uppercase;
        font-size: 1.8rem;
    }
    
    .contact-row {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
    }
    .contact-row .col-md-4 {
        display: flex;
    }
    .contact-card {
        flex-grow: 1;
        background-color: #fff; 
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
    }
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .contact-card .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background-color: #b38f53;
        color: white;
        border-radius: 50%;
        margin-bottom: 20px;
    }
    .contact-card .icon-circle svg {
        width: 30px;
        height: 30px;
        stroke: white;
        stroke-width: 1.5;
        fill: none;
    }
    .faq-item {
        margin-bottom: 25px; 
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0; 
    }
    .faq-item h5 {
        color: #1a1a1a;
        font-weight: 600;
        cursor: pointer;
        padding: 10px 0;
    }
    .faq-item .collapse {
        padding-left: 15px;
    }
    .faq-answer {
        color: #555;
        margin-top: 10px;
        line-height: 1.6;
    }
    
    .contact-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
        border: 1px solid #eee;
        border-radius: 15px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .form-control {
        border-radius: 8px;
    }
</style>

<main class="container">
    <div class="help-header">
        <h1>Centro de Ayuda y Contacto</h1>
        <p class="lead">¿Cómo podemos ayudarte hoy? Encuentra respuestas a tus preguntas o contacta con nuestro equipo.</p>
    </div>

    <div class="help-section container">
        <h2>Opciones de Contacto</h2>
        <div class="row text-center contact-row">
            <div class="col-md-4 mb-4">
                <div class="contact-card">
                    <div class="icon-circle">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.08 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <h4>Llamada Telefónica</h4>
                    <p>Llámanos para asistencia inmediata.</p>
                    <p class="text-gold" style="font-size:1.1rem; font-weight: 600;">+34 987 654 321</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="contact-card">
                    <div class="icon-circle">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <h4>Correo Electrónico</h4>
                    <p>Envíanos un email, respondemos en 24h.</p>
                    <p class="text-gold" style="font-size:1.1rem; font-weight: 600;">info@laranajewelry.com</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="contact-card">
                    <div class="icon-circle">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                    </div>
                    <h4>Guía de Pedidos</h4>
                    <p>Información sobre envíos, plazos y devoluciones.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="help-section container">
        <h2>Preguntas Frecuentes (FAQ)</h2>
        <div class="accordion" id="faqAccordion">

            <div class="faq-item">
                <h5 class="mb-0" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    ✦ ¿Qué materiales utilizan en las joyas?
                </h5>
                <div id="collapseOne" class="collapse" data-bs-parent="#faqAccordion">
                    <div class="faq-answer">
                        Utilizamos Plata de Ley 925, Oro Vermeil de 18k y acero inoxidable de grado quirúrgico. Siempre especificamos el material exacto en la descripción de cada producto. Nuestras joyas están libres de níquel para evitar alergias.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <h5 class="mb-0" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    ✦ ¿Cuál es vuestra política de devoluciones?
                </h5>
                <div id="collapseTwo" class="collapse" data-bs-parent="#faqAccordion">
                    <div class="faq-answer">
                        Aceptamos devoluciones en un plazo de 30 días desde la recepción del pedido, siempre que la joya se encuentre en su estado original y con el embalaje intacto. Por motivos de higiene, los pendientes no se pueden devolver a menos que estén defectuosos.
                    </div>
                </div>
            </div>

            <div class="faq-item" id="envios">
                <h5 class="mb-0" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    ✦ ¿Cuánto tardan en llegar los pedidos?
                </h5>
                <div id="collapseThree" class="collapse" data-bs-parent="#faqAccordion">
                    <div class="faq-answer">
                        El tiempo de envío estándar es de 3 a 5 días hábiles dentro de la península. También ofrecemos envío express (24-48h) con un coste adicional. Los pedidos internacionales varían entre 7 y 15 días. Recibirás un código de seguimiento por email.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <h5 class="mb-0" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    ✦ ¿Cómo puedo cuidar mis joyas?
                </h5>
                <div id="collapseFour" class="collapse" data-bs-parent="#faqAccordion">
                    <div class="faq-answer">
                        Recomendamos evitar el contacto con productos químicos (perfumes, cloro), quitarse las joyas antes de ducharse o dormir y guardarlas en un lugar seco. Para limpiarlas, utiliza un paño suave de microfibra.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="help-section container">
        <h2>Envíanos un Mensaje Directo</h2>
        <div class="contact-form-container">
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Tu Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Tu Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto (Ej: Duda sobre un pedido)</label>
                    <input type="text" class="form-control" id="asunto" name="asunto" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Tu Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-dark-elegant btn-lg">Enviar Mensaje</button>
                </div>
                <p class="text-muted mt-3 text-center" style="font-size:0.85rem;">Te responderemos en un plazo máximo de 24 horas hábiles.</p>
            </form>
        </div>
    </div>

</main>

<?php
include '../includes/footer.php'; 
?>