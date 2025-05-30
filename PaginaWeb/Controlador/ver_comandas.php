<?php
/**
 * Este archivo sirve para que el admin pueda ver todas las comandas hechas.
 * Solo deja entrar si eres admin, si no, te manda un error.
 * Saca la info de la base de datos y la devuelve en JSON, con los platos y cantidades de cada comanda.
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

try {
    $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
    $pdo = $conexion->getConexion();

    $sqlComanda = "
        SELECT c.id_comanda, c.email, c.fecha, d.nombre_plato, d.cantidad 
        FROM comandas c
        JOIN detalle_comanda d ON c.id_comanda = d.id_comanda
        ORDER BY c.fecha DESC
    ";

    $consultaComanda = $pdo->query($sqlComanda);
    $comandas = [];

    while ($fila = $consultaComanda->fetch(PDO::FETCH_ASSOC)) {
        $id = $fila['id_comanda'];
        if (!isset($comandas[$id])) {
            $comandas[$id] = [
                'id_comanda' => $id,
                'email' => $fila['email'],
                'fecha' => $fila['fecha'],
                'platos' => []
            ];
        }

        $comandas[$id]['platos'][] = [
            'nombre_plato' => $fila['nombre_plato'],
            'cantidad' => $fila['cantidad']
        ];
    }

    echo json_encode(array_values($comandas));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener comandas', 'detalle' => $e->getMessage()]);
}
?>
