<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /tienda_login_php/login.php');
    exit;
}

$mensaje_enviado = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($nombre === '') $errors[] = "El nombre es obligatorio.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email no válido.";
    if ($mensaje === '') $errors[] = "El mensaje no puede estar vacío.";

    if (empty($errors)) {
        // Aquí podrías enviar el email o guardar en DB
        $mensaje_enviado = true;
    }
}

include __DIR__ . '/../includes/header.php'; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contáctame</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .contacto-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border: 1px solid var(--borde);
            text-align: center;
        }

        .contacto-container h1 {
            margin-bottom: 24px;
            font-size: 2rem;
        }

        .contacto-container p {
            margin-bottom: 30px;
            color: #555;
        }

        .contacto-container input,
        .contacto-container textarea {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 1px solid var(--borde);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.25s ease;
        }

        .contacto-container input:focus,
        .contacto-container textarea:focus {
            outline: none;
            border-color: var(--dorado);
            box-shadow: 0 0 8px rgba(198,166,100,0.4);
        }

        .contacto-container button {
            padding: 14px 32px;
            font-size: 1rem;
            border-radius: 28px;
            border: none;
            background-color: var(--negro);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .contacto-container button:hover {
            background-color: var(--dorado);
            color: #fff;
            transform: translateY(-2px);
        }

        .mensaje-exito {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .mensaje-error {
            color: red;
            margin-bottom: 20px;
            text-align: left;
        }
    </style>
</head>
<body>


<main class="container opciones">
    <div class="contacto-container">
        <h1>Contáctanos</h1>
        <p>Si tienes dudas o quieres hacer un pedido, escríbenos usando el siguiente formulario.</p>

        <?php if ($mensaje_enviado): ?>
            <p class="mensaje-exito">✅ Tu mensaje ha sido enviado correctamente.</p>
        <?php elseif(!empty($errors)): ?>
            <div class="mensaje-error">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="contactame.php">
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="email" placeholder="Tu email" required>
            <textarea name="mensaje" rows="5" placeholder="Tu mensaje" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
