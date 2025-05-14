<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';

session_start();

if (filter_has_var(INPUT_POST, 'iniciarSesion')) {
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

                $stmtRol = $pdo->prepare("SELECT tipo FROM roles WHERE id_rol = :id_rol");
                $stmtRol->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $stmtRol->execute();
                $rol = $stmtRol->fetchColumn();

                $_SESSION['rol'] = $rol;

                switch ($rol) {
                    case "Administrador":
                        header("Location: invitado.html");
                        break;
                    case "Usuario":
                        header("Location: index.html");
                        break;
                    default:
                        echo "Rol desconocido";
                        break;
                }
                exit;
            } else {
                echo "Correo o contraseña incorrectos.";
            }
        } catch (Exception $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    } else {
        echo "Completa todos los campos.";
    }
}
