<?php

$pdo = new PDO("mysql:host=localhost;dbname=tienda;charset=utf8mb4", "root", "");


$email = "oscar@example.com";
$password_plano = "123456789";


$hash = password_hash($password_plano, PASSWORD_DEFAULT);


$stmt = $pdo->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hash]);

echo "✅ Usuario creado con éxito:<br>Email: $email<br>Contraseña: $password_plano";
