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

<main class="container">
    <!-- SECCIÓN 1: Información básica -->
    <section class="perfil-info" style="margin-bottom:50px;">
        <h2 style="margin-bottom:24px; font-size:2rem;">Información de usuario</h2>
        <div class="info-box" style="padding:20px; border:1px solid var(--borde); border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.05); max-width:500px;">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
            <p><strong>Registrado el:</strong>
                <?php 
                    try {
                        $sql = "SELECT fecha_registro FROM usuarios WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([':id' => $usuario['id']]);
                        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($resultado) {
                            echo htmlspecialchars($resultado['fecha_registro']);
                        } else {
                            echo "No disponible";
                        }
                    } catch (PDOException $e) {
                        echo "<span style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
                    }
                ?>
            </p>
            <p style="margin-top:15px;">
                <a href="logout.php" class="btn-line">Cerrar sesión</a>
            </p>
        </div>
    </section>

    <!-- SECCIÓN 2: Historial de pedidos estilo cards -->
    <section class="perfil-historial" style="margin-bottom:50px;">
        <h2 style="margin-bottom:24px; font-size:2rem;">Historial de pedidos</h2>
        <div class="grid-productos" style="gap:20px;">
            <?php
            try {
                $sql = "SELECT id, total, fecha FROM pedidos WHERE usuario_id = :usuario_id ORDER BY fecha";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':usuario_id' => $usuario['id']]);
                $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($pedidos) {
                    foreach ($pedidos as $pedido) {
                        echo "<div class='producto' style='padding:16px;'>";
                        echo "<h3>Pedido #{$pedido['id']}</h3>";
                        echo "<p><strong>Total:</strong> {$pedido['total']} €</p>";
                        echo "<p><strong>Fecha:</strong> {$pedido['fecha']}</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No has realizado ningún pedido.</p>";
                }
            } catch (PDOException $e) {
                echo "<span style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
            }
            ?>
        </div>
    </section>

    <!-- SECCIÓN 3: Administración (solo admin) estilo cards -->
    <?php if (!empty($usuario['admin']) && $usuario['admin'] == 1): ?>
    <section class="perfil-admin">
        <h2 style="margin-bottom:24px; font-size:2rem;">Usuarios registrados</h2>
        <div class="grid-productos" style="gap:20px;">
            <?php
            try {
                $sql = "SELECT id, nombre, email, admin, fecha_registro FROM usuarios";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($usuarios) {
                    foreach ($usuarios as $u) {
                        echo "<div class='producto' style='padding:16px;'>";
                        echo "<h3>" . htmlspecialchars($u['nombre']) . "</h3>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($u['email']) . "</p>";
                        echo "<p><strong>Admin:</strong> " . ($u['admin'] ? 'Sí' : 'No') . "</p>";
                        echo "<p><strong>Registro:</strong> {$u['fecha_registro']}</p>";
                        echo "<div style='margin-top:10px; display:flex; gap:8px;'>";
                        echo "<a href='modificar_usuarios.php?id={$u['id']}' class='btn-line'>Editar</a>";
                        echo "<a href='ver_historial.php?id={$u['id']}' class='btn-line'>Historial</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            } catch (PDOException $e) {
                echo "<span style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
            }
            ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
