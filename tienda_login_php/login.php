<?php
// ============================
// 🔐 INICIO DE SESIÓN
// ============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================
// ⚙️ CONFIGURACIÓN DE LA BD
// ============================
$host = '127.0.0.1';
$dbname = 'tienda';
$username = 'tienda_user';      // el usuario que creaste
$dbpassword = 'TuContraseña';   // la contraseña que pusiste

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// ============================
// 🧩 VARIABLES Y VALIDACIÓN
// ============================
$errors = [];
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar email
    if ($email === '') {
        $errors[] = "El email es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del email no es válido.";
    }

    // Validar contraseña
    if ($password === '') {
        $errors[] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 8) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    // ============================
    // 🧠 PROCESAR LOGIN
    // ============================
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, password, nombre, email FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // ✅ Guardar datos en sesión
            $_SESSION['usuario'] = [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'email' => $user['email']
            ];

            // 🔁 Redirigir a la página principal
            header("Location: ../index.php");
            exit;
        } else {
            $errors[] = "❌ Email o contraseña incorrectos.";
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LARANA JEWELRY · Iniciar sesión</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<?php if (isset($_SESSION['usuario'])): ?>
<script>
  window.opener.location.reload(); // recarga la página principal
  window.close(); // cierra la pestaña del login
</script>
<?php endif; ?>
<body class="auth-page">

  <div class="auth-box">
    <h2 class="title">LARANA JEWELRY</h2>
    <p class="muted">Introduce tus credenciales para continuar.</p>

    <?php if (!empty($errors)): ?>
      <div class="message">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="login.php" novalidate>
      <label for="email">Email</label>
      <input id="email" name="email" type="email"
             value="<?= htmlspecialchars($email) ?>"
             placeholder="tucorreo@ejemplo.com"
             autocomplete="username" required>

      <label for="password">Contraseña</label>
      <input id="password" name="password" type="password"
             placeholder="••••••••"
             minlength="8"
             autocomplete="current-password" required>

      <button type="submit">Entrar</button>

      <p>¿No tienes cuenta? <a href="registrer.php">Crear cuenta nueva</a></p>
    </form>
  </div>

</body>
</html>
