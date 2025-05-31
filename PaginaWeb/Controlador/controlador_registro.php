<?php

/**
 * Este archivo se encarga de registrar a un nuevo usuario.
 * Recibe los datos del formulario, los valida y, si todo está bien, crea el usuario en la base de datos.
 * Si algo sale mal, devuelve un mensaje en formato JSON.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/validaciones.php';

// Verifica que se envió el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, 'registrar')) {

    // Filtrar y validar los campos del formulario
    $email = validarEmail(filter_input(INPUT_POST, 'email'));
    $nombre = validarNombre(filter_input(INPUT_POST, 'nombre'));
    $apellidos = validarApellidos(filter_input(INPUT_POST, 'apellidos'));
    $direccion = validarDireccion(filter_input(INPUT_POST, 'direccion'));
    $clave = validarClave(filter_input(INPUT_POST, 'clave'));
    $id_rol = 2; // Usuario normal por defecto

    // Verifica si algún campo está mal o vacío
    if (!$email || !$nombre || !$apellidos || !$clave || !$direccion) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Datos inválidos o incompletos."]);
        exit;
    }

    // Crea el usuario con contraseña encriptada
    $clave_hashed = password_hash($clave, PASSWORD_BCRYPT);
    $usuario = new Usuario($email, $nombre, $apellidos, $direccion, $clave_hashed, $id_rol);

    // Intenta registrar el usuario
    if ($usuario->crearUsuario()) {
        header("Location: /Vista/login.html?mensaje=Registro exitoso");
        exit();
    } else {
        header("Location: /Vista/registro.html?error=registro");
        exit();
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "No se ha enviado el formulario correctamente."]);
}
