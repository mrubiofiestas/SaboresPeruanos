<?php
require_once __DIR__ . '/../Modelo/Comandas.php';

echo "==== INICIO DE PRUEBAS DE LA CLASE COMANDA ====\n";

// Prueba 1: Obtener todas las comandas sin filtrar por estado
$comandas = Comanda::obtenerTodas();
if (!empty($comandas)) {
    echo "obtenerTodas OK: Se encontraron " . count($comandas) . " comandas\n";
} else {
    echo "obtenerTodas falló o no hay comandas\n";
}

// Prueba 2: Obtener comandas pendientes
$pendientes = Comanda::obtenerTodas('pendiente');
if (!empty($pendientes)) {
    echo "obtenerTodas con estado 'pendiente' OK: Se encontraron " . count($pendientes) . " comandas pendientes\n";
} else {
    echo "obtenerTodas con estado 'pendiente' falló o no hay comandas pendientes\n";
}

// Prueba 3: Marcar como lista una comanda pendiente (solo si hay alguna)
if (!empty($pendientes)) {
    $idComanda = $pendientes[0]['id_comanda'];
    if (Comanda::marcarComoLista($idComanda)) {
        echo "marcarComoLista OK: Comanda con ID $idComanda marcada como lista\n";
    } else {
        echo "marcarComoLista falló: No se pudo actualizar la comanda con ID $idComanda\n";
    }
} else {
    echo "No hay comandas pendientes para probar marcarComoLista\n";
}

// Prueba 4: Intentar marcar como lista una comanda con ID inexistente
$idFalso = 999999;
if (!Comanda::marcarComoLista($idFalso)) {
    echo "marcarComoLista con ID inexistente fue correctamente rechazado\n";
} else {
    echo "marcarComoLista con ID inexistente no fue rechazado\n";
}

echo "==== FIN DE PRUEBAS DE LA CLASE COMANDA ====\n";
