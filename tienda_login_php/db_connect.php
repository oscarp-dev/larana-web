<?php
// --- Configuración global de sesión ---
ini_set('session.cookie_path', '/'); // hace que la cookie sea válida para todo el dominio

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Conexión a la base de datos ---
$host = '100.72.131.53';
$dbname = 'tienda';
$username = 'sanenfcor';
$password = '0147';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
