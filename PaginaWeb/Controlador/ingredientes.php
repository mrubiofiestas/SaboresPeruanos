<?php
/**
 * Este archivo se encarga de sacar los ingredientes de un plato específico.
 * Recibe el nombre del plato, busca los ingredientes en la base de datos y los devuelve en JSON.
 * Si no se manda el nombre del plato, devuelve un array vacío.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Conexion.php';
header('Content-Type: application/json');

// Verifica si se ha enviado 'nombre_plato'.
if (filter_has_var(INPUT_GET, 'nombre_plato')) {
    $nombrePlato = filter_input(INPUT_GET, 'nombre_plato');

    try {
        $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
        $pdo = $conexion->getConexion();

        $consulta = $pdo->prepare("SELECT nombre_ingrediente FROM llevan WHERE nombre_plato = :nombre");
        $consulta->bindParam(':nombre', $nombrePlato);
        $consulta->execute();

        $ingredientes = $consulta->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($ingredientes);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al obtener ingredientes: " . $e->getMessage()]);
    }

} else {
    echo json_encode([]);
}
