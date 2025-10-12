<?php
$Usuario=$_POST['username'];
$Contraseña=$_POST['password'];
$RepetirContraseña=$_POST['repitpassword'];
$Email=$_POST['email'];


$host="localhost";
$user="root";
$pass="";
$baseDatos="login_db";
$tabla="login";

$conexion = mysqli_connect ($host, $user, $pass, $baseDatos);

if (!$conexion){
    die ("Error al conectar" . mysqli_connect_error());

}
echo "Conectado Correctamente a la Base de Datos";

$consulta= "INSERT INTO login_db (username,password,repitpassword,email) VALUES ('$Usuario', '$Contraseña', '$RepetirContraseña', '$Email')";
if(mysqli_query($conexion,$consulta)){
    echo "Datos Ingresados Correctamente";
    //header es para redireccionar a una pagina despues del login
    header ("Location:home.html");
}

$consulta= "INSERT INTO login_db (username,password) VALUES ('$Usuario', '$Contraseña')";
if(mysqli_query($conexion,$consulta)){
    echo "Datos Ingresados Correctamente";
    //header es para redireccionar a una pagina despues del login
    header ("Location:home.html");
}
else{
    echo "ERROR:" . $consulta . "<br>" . mysqli_error($consulta);
}
?>