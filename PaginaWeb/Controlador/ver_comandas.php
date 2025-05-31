<?php
/**
 * Este archivo se encarga de obtener las comandas con estado "pendiente" desde la base de datos.
 * Por cada comanda también se consultan los platos correspondientes desde la tabla detalle_comanda.
 * Devuelve los datos en formato JSON.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */
session_start();

if (!isset($_SESSION['email']) || $_SESSION['rol'] !== 'Administrador') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado']);
    exit;
}

require_once '../Modelo/Conexion.php';
header('Content-Type: application/json');

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    // Obtener todas las comandas pendientes
    $consulta_pendiente = $pdo->prepare("SELECT * FROM comandas WHERE estado = 'pendiente'");
    $consulta_pendiente->execute();
    $comandas = $consulta_pendiente->fetchAll(PDO::FETCH_ASSOC);

    // Para cada comanda, buscar los platos y sus cantidades
    foreach ($comandas as &$comanda) {
        $consulta_plato = $pdo->prepare("SELECT nombre_plato, cantidad FROM detalle_comanda WHERE id_comanda = :id");
        $consulta_plato->bindParam(':id', $comanda['id_comanda'], PDO::PARAM_INT);
        $consulta_plato->execute();
        $comanda['platos'] = $consulta_plato->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode(['success' => true, 'comandas' => $comandas]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al obtener las comandas',
        'detalle' => $e->getMessage()
    ]);
}
