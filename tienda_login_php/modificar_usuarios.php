<?php
require_once "db_connect.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔒 Solo los administradores pueden acceder
if (empty($_SESSION['usuario']) || $_SESSION['usuario']['admin'] != 1) {
    header('Location: login.php');
    exit;
}

$errores = [];
$usuario_a_editar = null;

// 🔹 Si viene por GET → cargar los datos del usuario
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario_a_editar = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario_a_editar) {
            die("<p style='color:red;'>❌ Usuario no encontrado.</p>");
        }
    } catch (PDOException $e) {
        die("<p style='color:red;'>Error al cargar el usuario: " . htmlspecialchars($e->getMessage()) . "</p>");
    }
}

// 🔹 Si viene por POST → guardar los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $admin = isset($_POST['admin']) ? intval($_POST['admin']) : 0;

    if (empty($nombre)) $errores[] = "El nombre no puede estar vacío.";
    if (empty($apellido)) $errores[] = "El apellido no puede estar vacío.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    if (empty($telefono)) $errores[] = "El teléfono no puede estar vacío.";
    if (empty($direccion)) $errores[] = "La dirección no puede estar vacía.";

    if (empty($errores)) {
        try {
            // Si se envía una nueva contraseña, se actualiza encriptada
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios 
                        SET nombre = :nombre, apellido = :apellido, email = :email, 
                            password = :password, telefono = :telefono, 
                            direccion = :direccion, admin = :admin
                        WHERE id = :id";
                $params = [
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':telefono' => $telefono,
                    ':direccion' => $direccion,
                    ':admin' => $admin,
                    ':id' => $id
                ];
            } else {
                // Si no cambia la contraseña, no la tocamos
                $sql = "UPDATE usuarios 
                        SET nombre = :nombre, apellido = :apellido, email = :email, 
                            telefono = :telefono, direccion = :direccion, admin = :admin
                        WHERE id = :id";
                $params = [
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':email' => $email,
                    ':telefono' => $telefono,
                    ':direccion' => $direccion,
                    ':admin' => $admin,
                    ':id' => $id
                ];
            }

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            // Si el admin edita su propio perfil, actualiza la sesión
            if ($_SESSION['usuario']['id'] == $id) {
                $_SESSION['usuario'] = array_merge($_SESSION['usuario'], [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'telefono' => $telefono,
                    'direccion' => $direccion,
                    'admin' => $admin
                ]);
            }

            $_SESSION['mensaje_exito'] = "✅ Usuario actualizado correctamente.";
            header("Location: perfil.php");
            exit;
        } catch (PDOException $e) {
            $errores[] = "Error al guardar los cambios: " . htmlspecialchars($e->getMessage());
        }
    } else {
        // Cargar los datos actuales para mantener el formulario relleno
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario_a_editar = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

include __DIR__ . '/../includes/header.php';
?>

<main class="container">
    <h2>Editar usuario #<?= htmlspecialchars($usuario_a_editar['id'] ?? '') ?></h2>

    <?php if (!empty($errores)): ?>
        <div style="color:red;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($usuario_a_editar): ?>
        <form action="modificar_usuarios.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario_a_editar['id']) ?>">

            <p>
                <label>Nombre:</label><br>
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario_a_editar['nombre']) ?>" required>
            </p>

            <p>
                <label>Apellido:</label><br>
                <input type="text" name="apellido" value="<?= htmlspecialchars($usuario_a_editar['apellido']) ?>" required>
            </p>

            <p>
                <label>Email:</label><br>
                <input type="email" name="email" value="<?= htmlspecialchars($usuario_a_editar['email']) ?>" required>
            </p>

            <p>
                <label>Nueva contraseña:</label>
                <div style="align-items:center; gap:10px;">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        style="flex:1;"
                    >
                    <button 
                        type="button" 
                        id="togglePassword"
                        style="cursor:pointer;"
                    >
                        👁️
                    </button>
                </div>
            </p>

            <p>
                <label>Teléfono:</label><br>
                <input type="text" name="telefono" value="<?= htmlspecialchars($usuario_a_editar['telefono']) ?>" required>
            </p>

            <p>
                <label>Dirección:</label><br>
                <input type="text" name="direccion" value="<?= htmlspecialchars($usuario_a_editar['direccion']) ?>" required>
            </p>

            <p>
                <label>Administrador:</label><br>
                <select name="admin">
                    <option value="0" <?= $usuario_a_editar['admin'] == 0 ? 'selected' : '' ?>>No</option>
                    <option value="1" <?= $usuario_a_editar['admin'] == 1 ? 'selected' : '' ?>>Sí</option>
                </select>
            </p>

            <p>
                <strong>Fecha de registro:</strong> <?= htmlspecialchars($usuario_a_editar['fecha_registro']) ?>
            </p>

            <button type="submit">Guardar cambios</button>
            <a href="perfil.php" style="margin-left:10px;">Volver</a>
        </form>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../js/ver_contrasenia.js"></script>
