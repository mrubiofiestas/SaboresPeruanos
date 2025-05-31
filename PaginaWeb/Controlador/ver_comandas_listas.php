<?php
/**
 * Este archivo devuelve el historial de comandas marcadas como "listas".
 * Solo accesible por usuarios con rol de Administrador.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Conexion.php';
session_start();
header('Content-Type: application/json');

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Acceso no autorizado']);
    exit();
}

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    // Obtener todas las comandas con estado 'lista'
    $consulta_listas = $pdo->prepare("SELECT * FROM comandas WHERE estado = 'lista' ORDER BY fecha DESC");
    $consulta_listas->execute();
    $comandas = $consulta_listas->fetchAll(PDO::FETCH_ASSOC);

    // Añadir los platos correspondientes a cada comanda
    foreach ($comandas as &$comanda) {
        $consulta_platos = $pdo->prepare("SELECT nombre_plato, cantidad FROM detalle_comanda WHERE id_comanda = :id");
        $consulta_platos->bindParam(':id', $comanda['id_comanda'], PDO::PARAM_INT);
        $consulta_platos->execute();
        $comanda['platos'] = $consulta_platos->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode(['success' => true, 'comandas' => $comandas]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al obtener el historial',
        'detalle' => $e->getMessage()
    ]);
}