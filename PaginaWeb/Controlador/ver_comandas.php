<?php
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

    $sql = "
        SELECT c.id_comanda, c.email, c.fecha, d.nombre_plato, d.cantidad 
        FROM comandas c
        JOIN detalle_comanda d ON c.id_comanda = d.id_comanda
        ORDER BY c.fecha DESC
    ";

    $stmt = $pdo->query($sql);
    $comandas = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id_comanda'];
        if (!isset($comandas[$id])) {
            $comandas[$id] = [
                'id_comanda' => $id,
                'email' => $row['email'],
                'fecha' => $row['fecha'],
                'platos' => []
            ];
        }

        $comandas[$id]['platos'][] = [
            'nombre_plato' => $row['nombre_plato'],
            'cantidad' => $row['cantidad']
        ];
    }

    echo json_encode(array_values($comandas));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener comandas', 'detalle' => $e->getMessage()]);
}
?>
