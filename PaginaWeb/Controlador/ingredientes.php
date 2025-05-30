<?php
/**
 * Este archivo se encarga de sacar los ingredientes de un plato específico.
 * Recibe el nombre del plato por GET, busca los ingredientes en la base de datos y los devuelve en JSON.
 * Si no se manda el nombre del plato, devuelve un array vacío.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Conexion.php';
header('Content-Type: application/json');

if (isset($_GET['nombre_plato'])) {
    $nombrePlato = $_GET['nombre_plato'];

    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    $consulta_ingrediente = $pdo->prepare("SELECT nombre_ingrediente FROM llevan WHERE nombre_plato = :nombre");
    $consulta_ingrediente->bindParam(':nombre', $nombrePlato);
    $consulta_ingrediente->execute();

    $ingredientes = $consulta_ingrediente->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($ingredientes);
} else {
    echo json_encode([]);
}
