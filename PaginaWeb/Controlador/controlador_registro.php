<?php
/**
 * Este archivo se encarga de registrar a un nuevo usuario.
 * Recibe los datos del formulario, los valida y, si todo está bien, crea el usuario en la base de datos.
 * Si algo sale mal, manda un mensaje de error o redirige según el caso.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/validaciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, 'registrar')) {
    $email = validarEmail(filter_input(INPUT_POST, 'email'));
    $nombre = validarNombre(filter_input(INPUT_POST, 'nombre'));
    $apellidos = validarApellidos(filter_input(INPUT_POST, 'apellidos'));
    $direccion = validarDireccion(filter_input(INPUT_POST, 'direccion'));
    $clave = validarClave(filter_input(INPUT_POST, 'clave'));
    $id_rol = 2; // Por defecto, todos los que se registran son usuarios normales

    if (!$email || !$nombre || !$apellidos || !$clave || !$direccion) {
        echo "Error: Datos inválidos o incompletos.";
        exit;
    }
    $clave_hashed = password_hash($clave, PASSWORD_BCRYPT);
    $usuario = new Usuario($email, $nombre, $apellidos, $direccion, $clave_hashed, $id_rol);
    if ($usuario->crearUsuario()) {
        header("Location: /Vista/login.html?mensaje=Registro exitoso");
        exit();
    } else {
        header("Location: /Vista/registro.html?error=registro");
        exit();
    }
}
