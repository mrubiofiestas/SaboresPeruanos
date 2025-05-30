<?php
require_once __DIR__ . '/../Modelo/Usuario.php';
require_once __DIR__ . '/../Modelo/validaciones.php';

echo "===== PRUEBAS DE LA CLASE USUARIO =====\n";

// Crear un nuevo usuario
$usuario = new Usuario(
    "prueba@example.com",
    "Milagros",
    "Rubio Fiestas",
    "Av. Perú 123",
    "clave123",
    2 // rol de usuario normal
);

// Intentamos crearlo
if ($usuario->crearUsuario()) {
    echo "Usuario creado con éxito.\n";
} else {
    echo "No se pudo crear el usuario (puede que ya exista).\n";
}

// Buscamos el usuario por email
$buscado = Usuario::buscarUsuario("prueba@example.com");
if ($buscado) {
    echo "Usuario encontrado:\n";
    print_r($buscado);
} else {
    echo "Usuario no encontrado.\n";
}

// Intentamos crearlo otra vez (debería fallar)
$duplicado = new Usuario(
    "prueba@example.com",
    "OtroNombre",
    "OtroApellido",
    "Otra Direccion",
    "otraClave",
    2
);

if ($duplicado->crearUsuario()) {
    echo "ERROR: Se creó un usuario duplicado (esto no debería pasar).\n";
} else {
    echo "Duplicado no creado, como se esperaba.\n";
}

echo "===== FIN DE LAS PRUEBAS =====\n";
