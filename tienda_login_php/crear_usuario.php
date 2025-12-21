<?php
$host = '100.72.131.53';
$dbname = 'tienda';
$username = 'sanenfcor';
$dbpassword = '0147'; // la que definiste

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = 'elena2@ejemplo.com';
    $nombre = 'Elena';
    $password = '12345678'; // contraseña en claro
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
    $stmt->execute([
        'nombre' => $nombre,
        'email' => $email,
        'password' => $hash
    ]);

    echo "✅ Usuario creado correctamente";

} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}
