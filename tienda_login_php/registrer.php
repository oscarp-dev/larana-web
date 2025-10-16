<?php
// ----------------------------
// 🧠 1. Conexión a la base de datos
// ----------------------------
$host = '127.0.0.1';
$dbname = 'tienda';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// ----------------------------
// 🧩 2. Lógica del registro
// ----------------------------
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $acepta   = isset($_POST['acepta_terminos']) ? 1 : 0;

    // 🧱 Validaciones
    if (
        empty($nombre) || empty($apellido) || empty($email) || empty($password) ||
        empty($confirm) || empty($telefono) || empty($direccion)
    ) {
        $message = "⚠️ Por favor, completa todos los campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "⚠️ El correo electrónico no es válido.";
    } elseif (strlen($password) < 8) {
        $message = "⚠️ La contraseña debe tener al menos 8 caracteres.";
    } elseif ($password !== $confirm) {
        $message = "⚠️ Las contraseñas no coinciden.";
    } elseif (!$acepta) {
        $message = "⚠️ Debes aceptar los términos y condiciones.";
    } else {
        // 🔍 Verificar si el email ya existe
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
        $check->execute(['email' => $email]);

        if ($check->rowCount() > 0) {
            $message = "⚠️ Este correo ya está registrado.";
        } else {
            // 🔒 Encriptar contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 💾 Insertar usuario
            $stmt = $conn->prepare("
                INSERT INTO usuarios (nombre, apellido, email, password, telefono, direccion, acepta_terminos)
                VALUES (:nombre, :apellido, :email, :password, :telefono, :direccion, :acepta)
            ");

            $stmt->execute([
                'nombre'   => $nombre,
                'apellido' => $apellido,
                'email'    => $email,
                'password' => $hashedPassword,
                'telefono' => $telefono,
                'direccion'=> $direccion,
                'acepta'   => $acepta
            ]);

            $message = "✅ Registro exitoso. Ya puedes iniciar sesión.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - LARANA JEWELRY</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="auth-page">
  <div class="auth-box">
        <h2>Crear cuenta</h2>

        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña (mínimo 8 caracteres)" minlength="8" required>
            <input type="password" name="confirm_password" placeholder="Confirmar contraseña" minlength="8" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="direccion" placeholder="Dirección" required>

            <label>
                <input type="checkbox" name="acepta_terminos" required>
                Acepto los <a href="terminos.php" target="_blank">términos y condiciones</a>
            </label>

            <button type="submit">Registrarse</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>

