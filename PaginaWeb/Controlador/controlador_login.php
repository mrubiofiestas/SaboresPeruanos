<?php

/**
 * Este archivo se encarga de manejar el inicio de sesión de los usuarios.
 * Verifica el correo y la clave, y según el rol, los manda a la página que les toca.
 * Si algo falla, muestra un mensajito de error.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/validaciones.php';

session_start();

/**
 * Si llega una petición POST para iniciar sesión, se procesan los datos.
 * Se valida que el correo y la clave no estén vacíos.
 * Si todo está bien, busca al usuario y verifica la clave.
 * Si el usuario existe y la clave es correcta, guarda los datos en la sesión y redirige según el rol.
 * Si algo sale mal, muestra un mensaje de error.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, 'iniciarSesion')) {
    $email = filter_input(INPUT_POST, 'email');
    $clave = filter_input(INPUT_POST, 'clave');

    if (!empty($email) && !empty($clave)) {
        try {
            // Busca al usuario por su correo
            $usuario = Usuario::buscarUsuario($email);
            // Verifica que el usuario exista y la clave sea correcta
            if ($usuario && password_verify($clave, $usuario['clave'])) {
                // Guarda datos del usuario en la sesión
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre'] = $usuario['nombre'];

                // Conecta a la base de datos para obtener el rol
                $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
                $pdo = $conexion->getConexion();
                $id_rol = $usuario['id_rol'];

                $consultaRol = $pdo->prepare("SELECT tipo_rol FROM roles WHERE id_rol = :id_rol");
                $consultaRol->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $consultaRol->execute();
                $rol = $consultaRol->fetchColumn();

                $_SESSION['rol'] = $rol;

                // Redirige según el rol del usuario
                switch ($rol) {
                    case "Administrador":
                        header("Location: /Vista/comandas_admin.html");
                        break;
                    case "Usuario":
                        header("Location: /index.html");
                        break;
                    default:
                        echo "Rol desconocido";
                        break;
                }
                exit;
            } else {
                header("Location: /Vista/login.html?error=credenciales");
                exit();
            }
        } catch (Exception $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    } else {
        header("Location: /Vista/login.html?error=incompleto");
        exit();
    }
} else {
    header("Location: /Vista/login.html?error=no_autorizado");
    exit();
}
