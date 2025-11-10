<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../tienda_login_php/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='container'><h2>ID de producto no válido</h2></div>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM productos WHERE id = :id");
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() === 0) {
    echo "<div class='container'><h2>Producto no encontrado</h2></div>";
    exit;
}

$producto = $stmt->fetch(PDO::FETCH_ASSOC);
include __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="producto.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<section class="producto-detalle container">
  <div class="producto-layout">

    <!--  Imagen -->
    <div class="producto-media">
      <img src="../<?= htmlspecialchars($producto['imagen'])?>" 
           alt="<?= htmlspecialchars($producto['nombre']) ?>">
    </div>

    <!--  Información -->
    <div class="producto-info">
      <h1 class="titulo"><?= htmlspecialchars($producto['nombre']) ?></h1>
      <p class="precio">€<?= htmlspecialchars($producto['precio']) ?></p>
      <p class="precio-info">Impuestos incluidos — Envío gratuito desde 50€</p>

      <form action="../tienda_login_php/carrito.php" method="POST">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
        <input type="hidden" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>">
        <button type="submit" name="add_to_cart" class="btn-dorado">Añadir al carrito</button>
      </form>

      <ul class="atributos">
        <li>💧 Water resistant</li>
        <li>🌿 Hipoalergénico</li>
        <li>💎 Garantía de 3 años</li>
        <li>🔄 Cambios fáciles</li>
      </ul>

      <div class="detalles">
        <details class="detalle" open>
          <summary>Descripción</summary>
          <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
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

<!--  SECCIÓN DE RESEÑAS -->
<section class="reviews container">
  <h2>Opiniones de nuestros clientes</h2>

  <?php
  //  Calcular la media de estrellas y el total de reseñas
  $stmt_avg = $conn->prepare("
      SELECT 
          ROUND(AVG(stars), 1) AS average_rating,
          COUNT(*) AS total_reviews
      FROM reviews
      WHERE product_id = :id
  ");
  $stmt_avg->execute([':id' => $id]);
  $rating_data = $stmt_avg->fetch(PDO::FETCH_ASSOC);
  $average_rating = $rating_data['average_rating'];
  $total_reviews = $rating_data['total_reviews'];

  //  Mostrar resumen de valoración
if ($total_reviews > 0) {
    $rounded = round($average_rating);
    echo '<div class="rating-summary">';
    for ($i = 1; $i <= 5; $i++) {
        echo $i <= $rounded 
            ? '<i class="fa-solid fa-star filled"></i>' 
            : '<i class="fa-regular fa-star"></i>';
    }
    echo '<strong>' . $average_rating . '/5</strong>';
    echo '<span> basado en ' . $total_reviews . ' reseña' . ($total_reviews > 1 ? 's' : '') . '</span>';
    echo '</div>';
}

  ?>

  <div class="reviews-list">
    <?php
    //  Obtener reseñas del producto
    $stmt_reviews = $conn->prepare("
        SELECT name, stars, text, created_at 
        FROM reviews 
        WHERE product_id = :id 
        ORDER BY created_at DESC
    ");
    $stmt_reviews->execute([':id' => $id]);
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

    // 🪄 Mostrar reseñas
    if ($reviews) {
        foreach ($reviews as $r) {
            echo '<div class="review">';
            echo '<div class="review-header">';
            echo '<strong>' . htmlspecialchars($r['name']) . '</strong>';
            echo '<small>' . date("d/m/Y", strtotime($r['created_at'])) . '</small>';
            echo '</div>';
            echo '<div class="stars">' . str_repeat("★", $r['stars']) . str_repeat("☆", 5 - $r['stars']) . '</div>';
            echo '<p>' . nl2br(htmlspecialchars($r['text'])) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>Aún no hay reseñas para este producto. ¡Sé el primero en opinar!</p>";
    }
    ?>
  </div>

  <!--  Formulario para dejar una reseña -->
  <form id="reviewForm" method="POST" action="../tienda_login_php/agregar_resena.php" class="review-form">
    <h3 class="review-title">Escribe tu reseña</h3>
    <input type="hidden" name="product_id" value="<?= $id ?>">

    <label for="name">Tu nombre</label>
    <input type="text" id="name" name="name" placeholder="Escribe tu nombre..." required>

    <label>Valoración:</label>
<div class="star-rating">
  <i class="fa-solid fa-star" data-value="1"></i>
  <i class="fa-solid fa-star" data-value="2"></i>
  <i class="fa-solid fa-star" data-value="3"></i>
  <i class="fa-solid fa-star" data-value="4"></i>
  <i class="fa-solid fa-star" data-value="5"></i>
</div>
<input type="hidden" name="stars" id="stars" required>


    <label for="text">Tu opinión</label>
    <textarea id="text" name="text" rows="4" placeholder="Cuéntanos tu experiencia..." required></textarea>

    <button type="submit" class="btn-dorado">Enviar reseña</button>
    <p id="reviewMsg" style="display:none; margin-top:10px;"></p>
  </form>
</section>

<!--  Script para enviar la reseña sin recargar la página -->
<script>
document.getElementById('reviewForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const data = new FormData(form);

  const res = await fetch(form.action, { method: 'POST', body: data });
  const text = await res.text();

  const msg = document.getElementById('reviewMsg');
  msg.style.display = 'block';

  if (text.trim() === 'ok') {
    msg.style.color = 'green';
    msg.textContent = '¡Gracias por tu reseña!';
    form.reset();
  } else {
    msg.style.color = 'red';
    msg.textContent = 'Hubo un error al enviar tu reseña.';
  }
});
</script>
<script>
//  Interactividad de las estrellas
const stars = document.querySelectorAll('.star-rating .fa-star');
const starsInput = document.getElementById('stars');
let selected = 0;

stars.forEach(star => {
  star.addEventListener('mouseover', () => {
    resetStars();
    highlightStars(star.dataset.value);
  });

  star.addEventListener('mouseout', () => {
    resetStars();
    highlightStars(selected);
  });

  star.addEventListener('click', () => {
    selected = star.dataset.value;
    starsInput.value = selected;
    highlightStars(selected);
  });
});

function highlightStars(count) {
  stars.forEach(s => {
    if (s.dataset.value <= count) s.classList.add('active');
  });
}

function resetStars() {
  stars.forEach(s => s.classList.remove('active'));
}
</script>


<?php include __DIR__ . '/../includes/footer.php'; ?>
