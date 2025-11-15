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
    }

    .artesania-page {
        padding: 60px 0;
        text-align: center;
    }

    .artesania-page .container-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .artesania-header {
        margin-bottom: 60px;
    }

    .artesania-header .page-title {
        font-family: var(--font-heading);
        font-size: 3.5rem;
        color: var(--negro); 
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }

    .artesania-header .page-title::after {
        content: '';
        display: block;
        width: 40%;
        height: 4px;
        background-color: var(--dorado);
        margin: 10px auto 0 auto;
        border-radius: 2px;
    }

    .artesania-header .page-subtitle {
        font-family: var(--font-general);
        color: #555;
        font-size: 1.4rem;
        font-weight: 300;
        max-width: 800px;
        margin: 0 auto;
    }

    .proceso-seccion {
        display: flex;
        flex-direction: column;
        gap: 80px;
    }

    .paso-artesanal {
        display: flex;
        align-items: center;
        text-align: left;
        gap: 50px;
    }

    .paso-artesanal:nth-child(even) {
        flex-direction: row-reverse;
        text-align: right;
    }

    .paso-media {
        flex: 1;
        height: 380px; 
    }

    .paso-media img {
        width: 100%;
        height: 100%; 
        object-fit: cover; 
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .paso-texto {
        flex: 1.2;
        padding: 20px;
    }

    .paso-numero {
        font-family: var(--font-heading);
        font-size: 1.2rem;
        color: var(--dorado);
        font-weight: 700;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .paso-titulo {
        font-family: var(--font-heading);
        font-size: 2.2rem;
        color: var(--negro);
        margin-bottom: 15px;
    }

    .paso-descripcion {
        font-family: var(--font-general);
        font-size: 1rem;
        color: #666;
        line-height: 1.7;
    }

    .filosofia-seccion {
        background-color: #f7f7f7;
        padding: 80px 0;
        margin-top: 80px;
        text-align: center;
    }

    .filosofia-seccion h2 {
        font-family: var(--font-heading);
        font-size: 3rem;
        color: var(--negro);
        margin-bottom: 40px;
    }

    .compromiso-list {
        display: flex;
        justify-content: space-around;
        gap: 30px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .compromiso-item {
        flex: 1;
        max-width: 300px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: var(--blanco);
    }

    .compromiso-item i {
        font-size: 2.5rem;
        color: var(--dorado);
        margin-bottom: 15px;
    }

    .compromiso-item h3 {
        font-family: var(--font-heading);
        font-size: 1.2rem;
        color: var(--negro);
        margin-bottom: 10px;
    }

    .compromiso-item p {
        font-family: var(--font-general);
        font-size: 0.95rem;
        color: #777;
    }

    @media (max-width: 900px) {
        .paso-artesanal {
            flex-direction: column;
            text-align: center !important;
        }
        .paso-artesanal:nth-child(even) {
            flex-direction: column;
        }
        .paso-media, .paso-texto {
            flex: none;
            width: 100%;
        }
        .paso-media {
            height: 450px; 
        }
        .paso-media img {
            max-height: 100%;
            object-fit: cover;
        }
        .compromiso-list {
            flex-direction: column;
            align-items: center;
        }
        .compromiso-item {
            max-width: 90%;
        }
    }
</style>

<main class="main-content artesania-page">
    <div class="container-page">
        <header class="artesania-header">
            <h1 class="page-title">La Esencia Artesanal de LARANA</h1>
            <p class="page-subtitle">Cada joya es forjada con pasión y precisión, honrando técnicas ancestrales para crear piezas con alma y carácter único.</p>
        </header>

        <section class="proceso-seccion">
            
            <div class="paso-artesanal">
                <div class="paso-media">
                    <img src="../images/producto1.jpg" alt="Selección de materiales">
                </div>
                <div class="paso-texto">
                    <p class="paso-numero">Paso 1</p>
                    <h2 class="paso-titulo">Selección de Materia Prima</h2>
                    <p class="paso-descripcion">
                        Todo comienza con la elección de los metales más nobles: oro de 18k, plata de ley y baños de rodio de alta calidad. Inspeccionamos meticulosamente cada material para asegurar que solo lo mejor toque las manos de nuestros artesanos y, eventualmente, las tuyas.
                    </p>
                </div>
            </div>

            <div class="paso-artesanal">
                <div class="paso-media">
                    <img src="../images/historia.jpg" alt="Diseño y modelado">
                </div>
                <div class="paso-texto">
                    <p class="paso-numero">Paso 2</p>
                    <h2 class="paso-titulo">El Modelado y la Fundición</h2>
                    <p class="paso-descripcion">
                        Nuestros diseñadores crean bocetos y moldes a mano. La cera se funde, el metal se vierte y toma forma. Este es el corazón de la artesanía, donde la visión se convierte en una silueta tangible, manteniendo la perfección en las curvas y la fuerza en los enlaces.
                    </p>
                </div>
            </div>

            <div class="paso-artesanal">
                <div class="paso-media">
                    <img src="../images/producto2.jpg" alt="Pulido y acabado final">
                </div>
                <div class="paso-texto">
                    <p class="paso-numero">Paso 3</p>
                    <h2 class="paso-titulo">Pulido y Engaste de Gemas</h2>
                    <p class="paso-descripcion">
                        El acabado es lo que distingue una joya LARANA. Cada pieza se pule hasta alcanzar un brillo espejo. Si la joya lleva gemas, estas se engastan con precisión microscópica por expertos engastadores, garantizando seguridad y maximizando su resplandor.
                    </p>
                </div>
            </div>

        </section>
    </div>

    <section class="filosofia-seccion">
        <div class="container-page">
            <h2>Nuestra Filosofía de Compromiso</h2>
            <ul class="compromiso-list">
                <li class="compromiso-item">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h3>Hecho con el Corazón</h3>
                    <p>
                        No usamos producción en masa. Cada joya lleva la firma de la mano que la creó, un proceso lento que garantiza la máxima calidad y exclusividad.
                    </p>
                </li>
                <li class="compromiso-item">
                    <i class="fas fa-certificate"></i>
                    <h3>Calidad Garantizada</h3>
                    <p>
                        Solo trabajamos con materiales duraderos y resistentes al agua. Respaldamos cada pieza con una garantía de 3 años contra defectos de fabricación.
                    </p>
                </li>
                <li class="compromiso-item">
                    <i class="fas fa-globe-americas"></i>
                    <h3>Sostenibilidad</h3>
                    <p>
                        Nos esforzamos por reducir nuestro impacto, utilizando metales reciclados siempre que es posible y fomentando un proceso de producción ético.
                    </p>
                </li>
            </ul>
        </div>
    </section>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>