<?php
require_once '../Modelo/Conexion.php';

session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo "No has iniciado sesión.";
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || count($data) === 0) {
    http_response_code(400);
    echo "Carrito vacío.";
    exit;
}

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    $pdo->beginTransaction();

    // Crear pedido
    $stmt = $pdo->prepare("INSERT INTO pedido (descripcion, email_usuario) VALUES (:descripcion, :email)");
    $descripcion = implode(", ", array_column($data, 'nombre'));
    $stmt->execute([
        ':descripcion' => $descripcion,
        ':email' => $_SESSION['email']
    ]);
    $cod_pedido = $pdo->lastInsertId();

    // Insertar en contiene
    foreach ($data as $item) {
        $stmt = $pdo->prepare("INSERT INTO contiene (cod_pedido, nombre_plato) VALUES (:pedido, :plato)");
        $stmt->execute([
            ':pedido' => $cod_pedido,
            ':plato' => $item['nombre']
        ]);
    }

    $pdo->commit();
    echo "Pedido registrado correctamente.";
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo "Error al registrar pedido: " . $e->getMessage();
}
