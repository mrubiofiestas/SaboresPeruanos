<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/validaciones.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, 'iniciarSesion')) {
    $email = filter_input(INPUT_POST, 'email');
    $clave = filter_input(INPUT_POST, 'clave');

    if (!empty($email) && !empty($clave)) {
        try {
            $usuario = Usuario::buscarUsuario($email);
            if ($usuario && password_verify($clave, $usuario['clave'])) {
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre'] = $usuario['nombre'];

                $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
                $pdo = $conexion->getConexion();
                $id_rol = $usuario['id_rol'];

                $stmtRol = $pdo->prepare("SELECT tipo_rol FROM roles WHERE id_rol = :id_rol");
                $stmtRol->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $stmtRol->execute();
                $rol = $stmtRol->fetchColumn();

                $_SESSION['rol'] = $rol;

                switch ($rol) {
                    case "Administrador":
                        header("Location: /Vista/administrador.html");
                        break;
                    case "Usuario":
                        header("Location: /index.php");
                        break;
                    case "Invitado":
                        header("Location: /Vista/repartidor.php");
                        break;
                    default:
                        echo "Rol desconocido";
                        break;
                }
                exit;
            } else {
                echo "Error: Credenciales incorrectas.";
            }
        } catch (Exception $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    } else {
        echo "Completa todos los campos.";
    }
} else {
    echo "Acceso no autorizado.";
}
