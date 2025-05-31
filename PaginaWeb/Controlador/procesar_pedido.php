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

// Verifica si el usuario ha iniciado sesión
if (!filter_has_var(INPUT_SERVER, 'REQUEST_METHOD') || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

if (!isset($_SESSION['email'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

// Obtener datos JSON desde el body del request
$datosCrudos = file_get_contents("php://input");
$data = json_decode($datosCrudos, true);

// Validar contenido
if (!$data || !is_array($data) || count($data) === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Carrito vacío o datos inválidos']);
    exit;
}

$email = $_SESSION['email'];

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();
    $pdo->beginTransaction();

    // Insertar pedido
    $descripcion = implode(", ", array_column($data, 'nombre'));
    $consulta_pedido = $pdo->prepare("INSERT INTO pedido (descripcion, email_usuario) VALUES (:descripcion, :email)");
    $consulta_pedido->execute([
        ':descripcion' => $descripcion,
        ':email' => $email
    ]);
    $cod_pedido = $pdo->lastInsertId();

    // Insertar platos en contiene
    $consulta_contiene = $pdo->prepare("INSERT INTO contiene (cod_pedido, nombre_plato) VALUES (:pedido, :plato)");
    foreach ($data as $item) {
        $consulta_contiene->execute([
            ':pedido' => $cod_pedido,
            ':plato' => $item['nombre']
        ]);
    }

    // Insertar comanda
    $consulta_comanda = $pdo->prepare("INSERT INTO comandas (email) VALUES (:email)");
    $consulta_comanda->execute([':email' => $email]);
    $id_comanda = $pdo->lastInsertId();

    // Insertar detalles de la comanda
    $consulta_detalle = $pdo->prepare("INSERT INTO detalle_comanda (id_comanda, nombre_plato, cantidad) VALUES (:id, :plato, :cantidad)");
    foreach ($data as $item) {
        $cantidad = isset($item['cantidad']) ? intval($item['cantidad']) : 1;
        $consulta_detalle->execute([
            ':id' => $id_comanda,
            ':plato' => $item['nombre'],
            ':cantidad' => $cantidad
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al procesar el pedido',
        'detalle' => $e->getMessage()
    ]);
}
