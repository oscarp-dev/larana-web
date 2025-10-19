<?php include("../includes/header.php"); ?>

<link rel="stylesheet" href="../producto.css">

<section class="producto-detalle container">
  <div class="producto-layout">

    <!-- Imagen destacada -->
    <div class="producto-media">
      <div class="carousel">
        <img src="../images/producto1.jpg" alt="Anillo Minimal">
      </div>
    </div>

    <!-- Información del producto -->
    <div class="producto-info">
      <h1 class="titulo">Anillo Minimal</h1>
      <p class="precio">€90</p>
      <p class="precio-info">Impuestos incluidos — Envío gratuito desde 50€</p>

      <button class="btn-dorado">Añadir al carrito</button>

      <ul class="atributos">
        <li>💧 Water resistant</li>
        <li>🌿 Hipoalergénico</li>
        <li>💎 Garantía de 3 años</li>
        <li>🔄 Cambios fáciles</li>
      </ul>

      <div class="detalles">
        <details class="detalle" open>
          <summary>Descripción</summary>
          <p>
            Inspirado en la simplicidad de la forma natural, el <strong>Anillo Minimal</strong> combina elegancia y ligereza en una pieza única. 
            Elaborado en acero inoxidable con baño de oro de 18k, es resistente al agua, hipoalergénico y libre de níquel.
          </p>
          <p>
            Ideal para uso diario o para complementar tu look más sofisticado. Su diseño versátil encarna la esencia de la joyería contemporánea.
          </p>
        </details>

        <details class="detalle">
          <summary>Envíos y devoluciones</summary>
          <p>
            Envíos gratuitos a partir de 50€.  
            Entregas entre 2 y 5 días laborables.  
            Cambios y devoluciones disponibles en un plazo de 14 días sin coste adicional.
          </p>
        </details>
      </div>

    </div>
  </div>
</section>

<?php include("../includes/footer.php"); ?>


