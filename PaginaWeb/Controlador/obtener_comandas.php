<?php
require_once '../Modelo/Conexion.php';
session_start();

if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

header('Content-Type: application/json');

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();


    $consulta = $pdo->query("
        SELECT 
            p.cod_pedido, 
            p.descripcion, 
            p.email_usuario, 
            u.nombre, 
            u.apellidos 
        FROM pedido p
        JOIN usuario u ON p.email_usuario = u.email
        ORDER BY p.cod_pedido DESC
    ");

    $comandas = $consulta->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comandas);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al obtener comandas: " . $e->getMessage()]);
}
