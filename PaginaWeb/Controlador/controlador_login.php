<?php 

require_once 'Validaciones.php';
require_once 'Conexion.php';

session_start();

if (filter_has_var(INPUT_POST, 'iniciarSesion')) {
    $pdo = new Conexion("espectaculos", "localhost", "root");
    $pdo->getConexion();
    if (filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'clave')) {
        //validar email y clave con validaciones
        try {
                $consulta = $pdo->getConexion()->prepare("select login, clave, tipo from usuarios where login = :login"); //agregar tipo 
                $consulta->bindParam(':login', $login, PDO::PARAM_STR);
                $consulta->execute();
            } catch (Exception $exc) {
                exit("No se encontró la contraseña" . $exc->getMessage());
            }
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if ($resultado && password_verify($clave, $resultado['clave'])) {
                //Creamos sesion con el nombre de usuario
                $_SESSION['login'] = $resultado['login'];
                $id_rol = $resultado['tipo'];
                $buscarRol = $pdo->getConexion()->prepare("SELECT tipo FROM roles WHERE id_rol = :id_rol");
                $buscarRol->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $buscarRol->execute();
                $rol = $buscarRol->fetchColumn();
                $_SESSION['rol'] = $rol;
                switch ($rol) {
                    case "administrador":
                        header("Location: areaAdmin.php");
                        break;
                    case "usuario":
                        header("Location: areaUsuario.php");
                        break;
                    case "invitado":
                        header("Location: areaInvitado.php");
                        break;
                    default:
                        echo "Rol desconocido";
                        break;
                }
                $salida = "Sesión correcta.";
            } else {
                $salida = "Datos incorrectos";
            }
    }else {
            $salida = "Campos incompletos. Completa todos los campos.";
        }

}


?>