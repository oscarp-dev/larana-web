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
    <!-- SECCIÓN 1: Información básica -->
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

    <!-- SECCIÓN 2: Historial de pedidos -->
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

</section>

<section class="seccion-acciones-admin">
    <p>
        <a href="/J_S25_Tienda_Online/tienda_login_php/anadir_producto.php" class="btn-agregar-producto">Añadir producto</a>
    </p>
</section>

<?php endif; ?>