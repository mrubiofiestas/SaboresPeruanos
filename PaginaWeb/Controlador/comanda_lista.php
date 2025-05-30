<?php
/**
 * Este archivo sirve para marcar una comanda como "lista" (pedido listo).
 * Recibe el id de la comanda por POST y actualiza su estado en la base de datos.
 * Devuelve un JSON diciendo si todo salió bien o si hubo algún problema.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

header("Content-Type: application/json");

require_once '../Modelo/Conexion.php';
session_start();

/**
 * Si llega el id de la comanda por POST, intenta actualizar el estado a "lista".
 * Si todo va bien, responde con éxito. Si no, manda el error.
 */
if (filter_has_var(INPUT_POST, 'id')) {
    $datos = filter_input_array(INPUT_POST);

    try {
        $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
        $pdo = $conexion->getConexion();

        $stmt = $pdo->prepare("UPDATE comandas SET estado = 'lista' WHERE id_comanda = :id");
        $stmt->bindParam(':id', $datos['id']);
        $stmt->execute();

        echo json_encode(['exito' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['exito' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['exito' => false, 'error' => 'Datos incompletos']);
}
