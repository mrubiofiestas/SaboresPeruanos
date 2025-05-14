<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';

session_start();

if (filter_has_var(INPUT_POST, 'registrarse')) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nombre = filter_input(INPUT_POST, 'nombre');
    $apellidos = filter_input(INPUT_POST, 'apellidos');
    $direccion = filter_input(INPUT_POST, 'direccion');
    $clave = filter_input(INPUT_POST, 'clave');
    $confirmar_clave = filter_input(INPUT_POST, 'confirmar_clave');

    if ($email && $nombre && $apellidos && $direccion && $clave && $confirmar_clave) {
        if ($clave !== $confirmar_clave) {
            echo "Las contraseñas no coinciden.";
            exit;
        }

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $pdo = $conexion->getConexion();

            // Verificar si el usuario ya existe
            if (Usuario::buscarUsuario($email)) {
                echo "El correo ya está registrado.";
                exit;
            }

            // ID de rol por defecto (por ejemplo, 2 = Usuario)
            $id_rol = 2;

            // Crear el usuario
            $nuevoUsuario = new Usuario($email, $nombre, $apellidos, $direccion, $clave, $id_rol);
            if ($nuevoUsuario->crearUsuario()) {
                $_SESSION['email'] = $email;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['rol'] = 'Usuario';
                header("Location: index.html"); // Redirige al home después del registro
                exit;
            } else {
                echo "No se pudo registrar el usuario. Intenta más tarde.";
            }

        } catch (PDOException $e) {
            echo "Error al registrar: " . $e->getMessage();
        }

    } else {
        echo "Por favor, completa todos los campos.";
    }
}
