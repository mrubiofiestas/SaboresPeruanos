<?php
require_once '../Modelo/Administrador.php'; // Asegúrate de que esta ruta es correcta
session_start();

$admin = new Administrador();

// Agregar plato
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio'] ?? '';

    if ($nombre && $tipo && is_numeric($precio)) {
        $admin->agregarPlato($nombre, $tipo, $precio);
        header("Location: /Vista/administrador.html?success=agregado");
        exit();
    } else {
        header("Location: /Vista/administrador.html?error=campos_invalidos");
        exit();
    }
}

// Eliminar plato
if (isset($_POST['eliminar'])) {
    $nombre = $_POST['nombre'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    if ($nombre && $tipo) {
        $admin->eliminarPlato($nombre, $tipo);
        header("Location: /Vista/administrador.html?success=eliminado");
        exit();
    } else {
        header("Location: /Vista/administrador.html?error=campos_invalidos");
        exit();
    }
}

// Editar plato
if (isset($_POST['editar'])) {
    $nombre = $_POST['nombre'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio'] ?? '';

    if ($nombre && $tipo && is_numeric($precio)) {
        $admin->editarPlato($nombre, $tipo, $precio);
        header("Location: /Vista/administrador.html?success=editado");
        exit();
    } else {
        header("Location: /Vista/administrador.html?error=campos_invalidos");
        exit();
    }
}
?>
