<?php

$conn = new PDO("mysql:host=100.72.131.53;dbname=tienda;charset=utf8mb4", "root", "0147");


$email = "oscar@example.com";
$password_plano = "123456789";


$hash = password_hash($password_plano, PASSWORD_DEFAULT);


$stmt = $conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hash]);

echo "✅ Usuario creado con éxito:<br>Email: $email<br>Contraseña: $password_plano";
