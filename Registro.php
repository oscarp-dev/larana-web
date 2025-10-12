<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="styleLogin.css">
</head>
<body class="login">
    <div class="div01">
        <div class="div02">
            <h2>Registrate</h2>
            <form action="PruebaLogin.php" method="POST">
                <label>Usuario</label><br>
                <input class="cuadrotexto" type="text" name="username" required><br><br>
                <label>Contraseña</label><br>
                <input class="cuadrotexto" type="password" name="password" required><br><br>
                <label>Repetir Contraseña</label><br>
                <input class="cuadrotexto" type="password" name="repitpassword" required><br><br>
                <label>Email</label><br>
                <input class="cuadrotexto" type="text" name="email" required><br><br>
                <input class="boton" type="submit" value="Registrarse">
                
            </form>
        </div>
    </div>
</body>
</html>
