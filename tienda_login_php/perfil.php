<?php
require_once "db_connect.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si no hay usuario logueado, redirige
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];

include __DIR__ . '/../includes/header.php';
?>

<main>
    <section class="perfil-info">
        <h2 class="Titulo_Usu">Información de usuario</h2>
        <div class="Info_Usu">
            <p><strong>Nombre de usuario:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
            <p><strong>Registrado el:</strong>
                <?php 
                    try {
                        $sql = "SELECT fecha_registro FROM usuarios WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([':id' => $usuario['id']]);
                        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($resultado) {
                            echo htmlspecialchars($resultado['fecha_registro']) . "</p>";
                        } else {
                            echo "No disponible";
                        }
                    } catch (PDOException $e) {
                        echo "<p style='color:red;'>Error al obtener la fecha: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                ?>
            </p>
        </div>
        <p class="Boton_Sesion">
            <a href="/J_S25_Tienda_Online/tienda_login_php/logout.php" style="text-decoration: none;color: #ffffffff;">Cerrar sesión</a>
        </p>
    </section>

    <section class="perfil-historial">
        <h2 class="Titutlo_Pedidos">Historial de pedidos</h2>
        <?php
        try {
            $sql = "SELECT id, total, fecha FROM pedidos WHERE usuario_id = :usuario_id ORDER BY fecha";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':usuario_id' => $usuario['id']]);
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($pedidos) {
                echo "<ol>";
                foreach ($pedidos as $pedido) {
                    echo "<li>Pedido #{$pedido['id']} — Total: {$pedido['total']} € — Fecha: {$pedido['fecha']}</li>";
                }
                echo "</ol>";
            } else {
                echo "<p>No has realizado ningún pedido.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error al cargar historial: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </section>
    
    <section class="perfil-admin">

        <?php if ($usuario['admin'] == 1): ?>

        <h2 class="titulo-usuarios">Lista de usuarios registrados</h2>

        <?php
        try {
            $sql = "SELECT id, nombre, email, admin, fecha_registro FROM usuarios";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($usuarios) {
                // Clase específica para la tabla: 'lista-usuarios-admin'
                echo "<table class='lista-usuarios-admin'>";
                echo "<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Admin</th><th>Fecha de registro</th><th colspan='2'>Acciones</th></tr></thead>";
                echo "<tbody>";
                foreach ($usuarios as $u) {
                    echo "<tr>";
                    echo "<td>{$u['id']}</td>";
                    echo "<td>" . htmlspecialchars($u['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($u['email']) . "</td>";
                    echo "<td>" . ($u['admin'] ? 'TRUE' : 'FALSE') . "</td>";
                    echo "<td>{$u['fecha_registro']}</td>";
                    // Enlaces de la tabla con estilos sutiles
                    echo "<td><a class='enlace-accion' href='/J_S25_Tienda_Online/tienda_login_php/modificar_usuarios.php?id={$u['id']}'>Editar</a></td>";
                    echo "<td><a class='enlace-accion' href='/J_S25_Tienda_Online/tienda_login_php/ver_historial.php?id={$u['id']}'>Historial de compra</a></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            }
        } catch (PDOException $e) {
            // Clase 'error-message' para dar estilo al error
            echo "<p class='error-message'>Error al obtener usuarios: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
        
        <section class="seccion-acciones-admin text-center mt-5 mb-5">
            <p>
                <button type="button" class="btn-agregar-producto" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    Añadir producto
                </button>
            </p>
        </section>

        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    </div>
            </div>
        </div>

    </section> <?php endif; ?> </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addProductModal');
        if (!modal) return; // Salir si el usuario no es admin y el modal no existe

        const modalContent = modal.querySelector('.modal-content');
        
        modal.addEventListener('show.bs.modal', function () {
            // Carga el contenido de anadir_producto.php
            fetch('anadir_producto.php?is_modal=true') 
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(error => {
                    modalContent.innerHTML = '<div class="alert alert-danger p-4">Error al cargar el formulario: ' + error + '</div>';
                    console.error('Error al cargar el modal:', error);
                });
        });

        // Limpia el contenido del modal al cerrarse
        modal.addEventListener('hidden.bs.modal', function () {
            modalContent.innerHTML = '';
        });
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>