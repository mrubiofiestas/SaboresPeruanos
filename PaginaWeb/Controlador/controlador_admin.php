<?php
/**
 * Controlador para las acciones del admin sobre los platos.
 * Aquí el admin puede agregar, eliminar o editar platos del menú.
 * Si todo sale bien, redirige con mensaje de éxito; si no, manda error.
 * 
 * @author Milagros del Rosario Rubio Fiestas
  * @version 1.0
 * @package Controlador
 */

require_once '../Modelo/Administrador.php';
session_start();

$admin = new Administrador();

// Agregar plato
/**
 * Si se manda el formulario para agregar, valida los datos y llama a agregarPlato.
 * Redirige según si salió bien o mal.
 */
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
/**
 * Si se manda el formulario para eliminar, valida los datos y llama a eliminarPlato.
 * Redirige según si salió bien o mal.
 */
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
/**
 * Si se manda el formulario para editar, valida los datos y llama a editarPlato.
 * Redirige según si salió bien o mal.
 */
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
