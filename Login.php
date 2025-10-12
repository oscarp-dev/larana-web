<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styleLogin.css">
</head>
<body class="login">
    <div class="div01">
        <div class="div02">
            <h2>Iniciar Sesión</h2>
            <form action="PruebaLogin.php" method="POST">
                <label>Usuario</label><br>
                <input class="cuadrotexto" type="text" name="username" required><br><br>
                <label>Contraseña</label><br>
                <input class="cuadrotexto" type="password" name="password" required><br><br>
                <input class="boton" type="submit" value="Iniciar Sesión"><br><br>
                <p>¿No tienes cuenta? Registrate <a href="Registro.php">aqui</a></p><br>
            </form>
        </div>
    </div>
</body>
</html>