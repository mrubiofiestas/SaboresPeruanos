<?php
/**
 * Controlador para las acciones del admin sobre los platos.
 * Aquí el admin puede agregar, eliminar o editar platos del menú.
 * Si todo sale bien, redirige con mensaje de éxito; si no, manda error.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @version 1.1
 * @package Controlador
 */

require_once '../Modelo/Administrador.php';
session_start();

$admin = new Administrador();

// Agregar plato
if (filter_has_var(INPUT_POST, 'agregar')) {
    $nombre = filter_input(INPUT_POST, 'nombre');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);

    if ($nombre && $tipo && $precio !== false) {
        $admin->agregarPlato($nombre, $tipo, $precio);
        header("Location: /Vista/administrador.html?success=agregado");
        exit();
    } else {
        header("Location: /Vista/administrador.html?error=campos_invalidos");
        exit();
    }
}

// Eliminar plato
if (filter_has_var(INPUT_POST, 'eliminar')) {
    $nombre = filter_input(INPUT_POST, 'nombre');
    $tipo = filter_input(INPUT_POST, 'tipo');

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
if (filter_has_var(INPUT_POST, 'editar')) {
    $nombre = filter_input(INPUT_POST, 'nombre');
    $tipo = filter_input(INPUT_POST, 'tipo');
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);

    if ($nombre && $tipo && $precio !== false) {
        $admin->editarPlato($nombre, $tipo, $precio);
        header("Location: /Vista/administrador.html?success=editado");
        exit();
    } else {
        header("Location: /Vista/administrador.html?error=campos_invalidos");
        exit();
    }
}
