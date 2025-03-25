<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';

session_start();

//corregir 
if (filter_has_var(INPUT_POST, 'iniciarSesion')) {
    $pdo = new Conexion("sabores_peruanos", "localhost", "root");
    $pdo->getConexion();
    if (filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'clave')) {
        try {
            $consulta = $pdo->getConexion()->prepare("select email, clave, tipo from usuario where email = :email");
            $consulta->bindParam(':email', $email);
            $consulta->execute();
        } catch (Exception $exc) {
            exit("No se encontró la contraseña" . $exc->getMessage());
        }
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($resultado && password_verify($clave, $resultado['clave'])) {
            $_SESSION['login'] = $resultado['login'];
            $id_rol = $resultado['tipo'];
            $buscarRol = $pdo->getConexion()->prepare("SELECT tipo FROM roles WHERE id_rol = :id_rol");
            $buscarRol->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $buscarRol->execute();
            $rol = $buscarRol->fetchColumn();
            $_SESSION['rol'] = $rol;
            switch ($rol) {
                case "Administrador":
                    header("Location: areaAdmin.php");
                    break;
                case "Usuario":
                    header("Location: index.html");
                    break;
                case "Repartidor":
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
    } else {
        $salida = "Campos incompletos. Completa todos los campos.";
    }
}
