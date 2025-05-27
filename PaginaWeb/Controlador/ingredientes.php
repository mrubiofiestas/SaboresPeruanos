<?php
require_once '../Modelo/Conexion.php';

if (isset($_GET['nombre_plato'])) {
    $nombrePlato = $_GET['nombre_plato'];

    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    $stmt = $pdo->prepare("SELECT nombre_ingrediente FROM ingredientes WHERE nombre_plato = :nombre");
    $stmt->bindParam(':nombre', $nombrePlato, PDO::PARAM_STR);
    $stmt->execute();

    $ingredientes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($ingredientes);
} else {
    echo json_encode([]);
}
