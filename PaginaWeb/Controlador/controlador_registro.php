<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/validaciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, 'registrar')) {
    $email = validarEmail(filter_input(INPUT_POST, 'email'));
    $nombre = validarNombre(filter_input(INPUT_POST, 'nombre'));
    $apellidos = validarApellidos(filter_input(INPUT_POST, 'apellidos'));
    $direccion = validarDireccion(filter_input(INPUT_POST, 'direccion'));
    $clave_original = validarClave(filter_input(INPUT_POST, 'clave'));
    $id_rol = 2;

    if (!$email || !$nombre || !$apellidos || !$clave_original) {
        echo "Error: Datos inválidos o incompletos.";
        exit;
    }
    $clave_hashed = password_hash($clave_original, PASSWORD_BCRYPT);

    $usuario = new Usuario($email, $nombre, $apellidos, $direccion, $clave_hashed, $id_rol);

    if ($usuario->crearUsuario()) {
        header("Location: /Vista/login.html?mensaje=Registro exitoso");
        exit();
    } else {
        echo "Error: No se pudo registrar el usuario. Puede que ya exista.";
        exit();
    }
}
