<?php
require_once __DIR__ . '/../Modelo/Administrador.php';
require_once __DIR__ . '/../Modelo/validaciones.php';

echo "==== INICIO DE PRUEBAS DE ADMINISTRADOR ====\n";

$admin = new Administrador();

//Prueba 1: agregarPlato con datos válidos
if ($admin->agregarPlato("TestPlato", "fondo", 25.50)) {
    echo "agregarPlato con datos válidos OK\n";
} else {
    echo "agregarPlato con datos válidos falló\n";
}

//Prueba 2: agregarPlato con precio inválido
if (!$admin->agregarPlato("PlatoError", "fondo", -10)) {
    echo "agregarPlato con precio inválido fue rechazado\n";
} else {
    echo "agregarPlato con precio inválido no fue rechazado\n";
}

//Prueba 3: editarPlato (cambiando nombre, tipo y precio)
if ($admin->editarPlato("TestPlato", "postre", 30.00)) {
    echo "editarPlato OK\n";
} else {
    echo "editarPlato falló\n";
}

//Prueba 4: editarPlato con nombre inexistente
if (!$admin->editarPlato("NoExiste", "Nuevo", "entrada", 20.00)) {
    echo "editarPlato con nombre inexistente fue rechazado\n";
} else {
    echo "editarPlato con nombre inexistente no fue rechazado\n";
}

//Prueba 5: eliminarPlato existente
if ($admin->eliminarPlato("TestPlato")) {
    echo "eliminarPlato existente OK\n";
} else {
    echo "eliminarPlato existente falló\n";
}

//Prueba 6: eliminarPlato inexistente
if (!$admin->eliminarPlato("NoExiste")) {
    echo "eliminarPlato inexistente fue correctamente rechazado\n";
} else {
    echo "eliminarPlato inexistente no fue rechazado\n";
}

echo "==== FIN DE PRUEBAS ====\n";
