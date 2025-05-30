<?php
require_once __DIR__ . '/../Modelo/Plato.php';
require_once __DIR__ . '/../Modelo/validaciones.php';

echo "==== INICIO DE PRUEBAS DE LA CLASE PLATO ====\n";

//Prueba 1: Crear objeto y agregar plato
$plato = new Plato("PlatoPrueba2", "entrada", 19.99);
if ($plato->agregarPlato()) {
    echo "agregarPlato con objeto Plato OK\n";
} else {
    echo "agregarPlato falló\n";
}

//Prueba 2: Editar plato existente
$platoEditado = new Plato("PlatoEditado", "postre", 22.50);
if ($platoEditado->editarPlato("PlatoPrueba2")) {
    echo "editarPlato OK\n";
} else {
    echo "editarPlato falló\n";
}

//Prueba 3: Obtener todos los platos
$platos = Plato::obtenerTodos();
if (!empty($platos)) {
    echo "obtenerTodos OK: Se encontraron " . count($platos) . " platos\n";
} else {
    echo "obtenerTodos falló o no hay platos\n";
}

//Prueba 4: Eliminar plato existente
if (Plato::eliminarPlato("PlatoEditado")) {
    echo "eliminarPlato OK\n";
} else {
    echo "eliminarPlato falló\n";
}

//Prueba 5: Eliminar plato que no existe
if (!Plato::eliminarPlato("NoExiste")) {
    echo "eliminarPlato con nombre inexistente fue rechazado\n";
} else {
    echo "eliminarPlato con nombre inexistente no fue rechazado\n";
}

echo "==== FIN DE PRUEBAS DE LA CLASE PLATO ====\n";
