<?php
// 🔹 Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 🔹 Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Conectar con la base de datos (ruta relativa correcta)
require_once "db_connect.php";

$errors = [];
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// ✅ Guardar la última página visitada (si no estamos en login o register)
if (!isset($_SESSION['ultima_pagina']) && isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    if (strpos($referer, 'login.php') === false && strpos($referer, 'register.php') === false) {
        $_SESSION['ultima_pagina'] = $referer;
    }
}

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
        // 🔹 Preparar y ejecutar consulta segura
        $stmt = $conn->prepare("SELECT id, password, nombre, apellido, email, admin FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // ✅ Guardar datos en sesión
            $_SESSION['usuario'] = [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'apellido' => $user['apellido'],
                'email' => $user['email'],
                'admin' => $user['admin']
            ];

            // ✅ Redirigir a la última página visitada si existe
            if (!empty($_SESSION['ultima_pagina'])) {
                $destino = $_SESSION['ultima_pagina'];
                unset($_SESSION['ultima_pagina']); // limpiar
                header("Location: $destino");
                exit;
            }

            // 🔁 Si no hay página anterior, ir al inicio
            header("Location: ../index.php"); // subimos un nivel si accedemos desde /categorias/
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

      <p>¿No tienes cuenta? <a href="register.php">Crear cuenta nueva</a></p>
    </form>
  </div>

</body>
</html>
