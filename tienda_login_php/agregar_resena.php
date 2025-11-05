<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
require_once __DIR__ . '/db_connect.php';

//  Verificar que la solicitud venga por método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //  Recoger los datos enviados desde el formulario
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $name       = isset($_POST['name']) ? trim($_POST['name']) : '';
    $stars      = isset($_POST['stars']) ? intval($_POST['stars']) : 0;
    $text       = isset($_POST['text']) ? trim($_POST['text']) : '';

    //  Validar que los campos no estén vacíos y que las estrellas estén entre 1 y 5
    if ($product_id > 0 && !empty($name) && !empty($text) && $stars >= 1 && $stars <= 5) {
        try {
            //  Preparar la consulta SQL para insertar la reseña
            $stmt = $conn->prepare("
                INSERT INTO reviews (product_id, name, stars, text)
                VALUES (:product_id, :name, :stars, :text)
            ");

            // 🔒 Enlazar los valores de forma segura
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':stars', $stars, PDO::PARAM_INT);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);

            //  Ejecutar la consulta
            $stmt->execute();

            // 💬 Enviar respuesta de éxito (la leerá el JavaScript del formulario)
            echo "ok";
        } catch (PDOException $e) {
            //  Si ocurre un error con la base de datos
            echo "error";
        }
    } else {
        //  Si los datos no son válidos o faltan campos
        echo "error";
    }
}
?>
