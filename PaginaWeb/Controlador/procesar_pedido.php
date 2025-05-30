<?php
/**
 * Este archivo se encarga de procesar el pedido que hace el usuario.
 * Recibe los datos del carrito en JSON, guarda el pedido y sus detalles en la base de datos.
 * Si el usuario no está logueado o el carrito está vacío, manda un error.
 * Si todo sale bien, responde con éxito; si algo falla, manda el error.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

session_start();
require_once '../Modelo/Conexion.php';

if (!isset($_SESSION['email'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || count($data) === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Carrito vacío']);
    exit;
}

$email = $_SESSION['email'];

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();
    $pdo->beginTransaction();

    // 1. Insertar en tabla pedido
    $descripcion = implode(", ", array_column($data, 'nombre'));
    $stmtPedido = $pdo->prepare("INSERT INTO pedido (descripcion, email_usuario) VALUES (:descripcion, :email)");
    $stmtPedido->execute([
        ':descripcion' => $descripcion,
        ':email' => $email
    ]);
    $cod_pedido = $pdo->lastInsertId();

    // 2. Insertar en contiene
    $stmtContiene = $pdo->prepare("INSERT INTO contiene (cod_pedido, nombre_plato) VALUES (:pedido, :plato)");
    foreach ($data as $item) {
        $stmtContiene->execute([
            ':pedido' => $cod_pedido,
            ':plato' => $item['nombre']
        ]);
    }

    // 3. Insertar en comandas
    $stmtComanda = $pdo->prepare("INSERT INTO comandas (email) VALUES (:email)");
    $stmtComanda->bindParam(':email', $email);
    $stmtComanda->execute();
    $id_comanda = $pdo->lastInsertId();

    // 4. Insertar en detalle_comanda
    $stmtDetalle = $pdo->prepare("INSERT INTO detalle_comanda (id_comanda, nombre_plato, cantidad) VALUES (:id, :plato, :cantidad)");
    foreach ($data as $item) {
        $cantidad = $item['cantidad'] ?? 1;
        $stmtDetalle->execute([
            ':id' => $id_comanda,
            ':plato' => $item['nombre'],
            ':cantidad' => $cantidad
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al procesar el pedido',
        'detalle' => $e->getMessage()
    ]);
}
