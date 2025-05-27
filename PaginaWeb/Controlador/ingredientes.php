<?php
require_once '../Modelo/Conexion.php';
header('Content-Type: application/json');

if (isset($_GET['nombre_plato'])) {
    $nombrePlato = $_GET['nombre_plato'];

    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    $stmt = $pdo->prepare("SELECT nombre_ingrediente FROM llevan WHERE nombre_plato = :nombre");
    $stmt->bindParam(':nombre', $nombrePlato, PDO::PARAM_STR);
    $stmt->execute();

    $ingredientes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($ingredientes); // Devuelve [] si no hay resultados
} else {
    echo json_encode([]); // En caso no se pase nombre_plato
}
