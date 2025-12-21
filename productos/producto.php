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


<section class="producto-detalle-page container-page">
  <div class="producto-layout-grid">

    <div class="producto-media-box">
      <img src="../<?= htmlspecialchars($producto['imagen'])?>" 
           alt="<?= htmlspecialchars($producto['nombre']) ?>"
           class="producto-imagen-principal">
    </div>

    <div class="producto-info-box">
      <h1 class="producto-titulo"><?= htmlspecialchars($producto['nombre']) ?></h1>
      
      <?php
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

      if ($total_reviews > 0) {
          $rounded = round($average_rating);
          echo '<div class="producto-rating-summary">';
          for ($i = 1; $i <= 5; $i++) {
              echo $i <= $rounded 
                  ? '<i class="fa-solid fa-star review-filled"></i>' 
                  : '<i class="fa-regular fa-star review-empty"></i>';
          }
          echo '<strong class="rating-value">' . $average_rating . '/5</strong>';
          echo '<span class="review-count">(' . $total_reviews . ' reseñas)</span>';
          echo '</div>';
      }
      ?>

      <p class="producto-precio">€<?= htmlspecialchars($producto['precio']) ?></p>
      <p class="producto-envio-info">Impuestos incluidos — Envío gratuito desde 50€</p>

      <form action="../tienda_login_php/carrito.php" method="POST" class="compra-form">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
        <input type="hidden" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>">
        <button type="submit" name="add_to_cart" class="btn-dorado">
            <i class="fas fa-shopping-cart"></i> Añadir al carrito
        </button>
      </form>

      <ul class="producto-atributos-list">
        <li><i class="fas fa-tint"></i> Water resistant</li>
        <li><i class="fas fa-leaf"></i> Hipoalergénico</li>
        <li><i class="fas fa-gem"></i> Garantía de 3 años</li>
        <li><i class="fas fa-exchange-alt"></i> Cambios fáciles</li>
      </ul>

    </div>
  </div>
    
  <div class="producto-detalles-texto">
      
      <h3 class="detalle-titulo">Descripción del Producto</h3>
      <div class="detalle-texto-content">
          <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
      </div>

      <h3 class="detalle-titulo">Envíos y Devoluciones</h3>
      <div class="detalle-texto-content">
          <ul class="envio-list">
              <li>Envíos gratuitos a partir de 50€.</li>
              <li>Entregas entre 2 y 5 días laborables.</li>
              <li>Cambios y devoluciones disponibles en un plazo de 14 días sin coste adicional.</li>
          </ul>
      </div>

  </div>
</section>

<section class="reviews-section container-page">
  <h2 class="reviews-section-title">Opiniones de nuestros clientes</h2>

  <?php
  // El cálculo del rating ya se hizo arriba
  if ($total_reviews > 0) {
      $rounded = round($average_rating);
      echo '<div class="rating-summary-full">';
      for ($i = 1; $i <= 5; $i++) {
          echo $i <= $rounded 
              ? '<i class="fa-solid fa-star review-filled-lg"></i>' 
              : '<i class="fa-regular fa-star review-empty-lg"></i>';
      }
      echo '<strong class="rating-average">' . $average_rating . '/5</strong>';
      echo '<span class="review-total-count">' . $total_reviews . ' Reseña' . ($total_reviews > 1 ? 's' : '') . '</span>';
      echo '</div>';
  } else {
    echo "<p class='no-reviews-message'>Aún no hay reseñas para este producto. ¡Sé el primero en opinar!</p>";
  }
  ?>

  <div class="reviews-list-container">
    <?php
    // Obtener reseñas del producto
    $stmt_reviews = $conn->prepare("
        SELECT name, stars, text, created_at 
        FROM reviews 
        WHERE product_id = :id 
        ORDER BY created_at DESC
    ");
    $stmt_reviews->execute([':id' => $id]);
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar reseñas
    if ($reviews) {
        foreach ($reviews as $r) {
            echo '<div class="review-item-card">';
            echo '<div class="review-header-card">';
            
            echo '<div class="review-name-date">';
            echo '<strong class="review-user-name">' . htmlspecialchars($r['name']) . '</strong>';
            echo '<small class="review-date-text">' . date("d/m/Y", strtotime($r['created_at'])) . '</small>';
            echo '</div>'; // close review-name-date

            echo '<div class="review-stars-display">';
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $r['stars'] 
                    ? '<i class="fa-solid fa-star review-filled-sm"></i>' 
                    : '<i class="fa-regular fa-star review-empty-sm"></i>';
            }
            echo '</div>'; // close review-stars-display

            echo '</div>'; // close review-header-card
            echo '<p class="review-text-content">' . nl2br(htmlspecialchars($r['text'])) . '</p>';
            echo '</div>'; // close review-item-card
        }
    }
    ?>
  </div>

  <form id="reviewForm" method="POST" action="../tienda_login_php/agregar_resena.php" class="review-form-card">
    <h3 class="review-form-title">Escribe tu reseña</h3>
    <input type="hidden" name="product_id" value="<?= $id ?>">

    <div class="form-group-review">
        <label for="name">Tu nombre</label>
        <input type="text" id="name" name="name" placeholder="Escribe tu nombre..." required>
    </div>

    <div class="form-group-review">
        <label>Valoración:</label>
        <div class="star-rating-input" role="radiogroup" aria-label="Valoración del producto">
            <i class="fa-solid fa-star star-input-icon" data-value="1" role="radio" aria-label="1 estrella"></i>
            <i class="fa-solid fa-star star-input-icon" data-value="2" role="radio" aria-label="2 estrellas"></i>
            <i class="fa-solid fa-star star-input-icon" data-value="3" role="radio" aria-label="3 estrellas"></i>
            <i class="fa-solid fa-star star-input-icon" data-value="4" role="radio" aria-label="4 estrellas"></i>
            <i class="fa-solid fa-star star-input-icon" data-value="5" role="radio" aria-label="5 estrellas"></i>
        </div>
        <input type="hidden" name="stars" id="stars" required>
    </div>

    <div class="form-group-review">
        <label for="text">Tu opinión</label>
        <textarea id="text" name="text" rows="4" placeholder="Cuéntanos tu experiencia..." required></textarea>
    </div>

    <button type="submit" class="btn-dorado review-submit-btn">Enviar reseña</button>
    <p id="reviewMsg" class="review-message-status" style="display:none;"></p>
  </form>
</section>

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
        msg.textContent = '¡Gracias por tu reseña! (La página se recargará para verla)';
        form.reset();
        setTimeout(() => window.location.reload(), 2000); 
    } else {
        msg.style.color = 'red';
        msg.textContent = 'Hubo un error al enviar tu reseña.';
    }
});
</script>
<script>
// Interactividad de las estrellas
const stars = document.querySelectorAll('.star-rating-input .star-input-icon');
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
        if (s.dataset.value <= count) s.classList.add('active-star');
    });
}

function resetStars() {
    stars.forEach(s => s.classList.remove('active-star'));
}
</script>


<?php include __DIR__ . '/../includes/footer.php'; ?>