<?php
// Inicia sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Conexión a la base de datos ---
$host = '127.0.0.1';
$dbname = 'tienda';
$username = 'elena';          // tu usuario MySQL creado
$password = 'tu_contraseña';  // la contraseña que pusiste al crear el usuario

try {
    // Conexión PDO a MySQL
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configurar para que lance excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// --- Crear tablas básicas si no existen ---
try {
    // Tabla usuarios
    $conn->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            contraseña VARCHAR(255) NOT NULL,
            fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // Tabla productos
    $conn->exec("
        CREATE TABLE IF NOT EXISTS productos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            descripcion TEXT,
            precio DECIMAL(10,2) NOT NULL,
            stock INT DEFAULT 0,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // Tabla pedidos (opcional para pruebas)
    $conn->exec("
        CREATE TABLE IF NOT EXISTS pedidos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_usuario INT NOT NULL,
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            total DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

} catch (PDOException $e) {
    die("Error al crear tablas: " . $e->getMessage());
}

?>
