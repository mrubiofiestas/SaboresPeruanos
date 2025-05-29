<?php
require_once 'Administrador.php';
require_once 'validaciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? validarNombre($_POST['nombre']) : null;
    $tipo = isset($_POST['tipo']) ? validarNombre($_POST['tipo']) : null;
    $precio = isset($_POST['precio']) ? validarPrecio($_POST['precio']) : null;

    $admin = new Administrador();

    if (isset($_POST['agregar'])) {
        if ($nombre && $tipo && $precio) {
            if ($admin->agregarPlato($nombre, $tipo, $precio)) {
                header('Location: admin.html?mensaje=plato_agregado');
                exit;
            } else {
                echo "Error al agregar plato.";
            }
        } else {
            echo "Datos inválidos para agregar.";
        }
    }

    if (isset($_POST['eliminar'])) {
        if ($nombre && $tipo) {
            if ($admin->eliminarPlato($nombre, $tipo)) {
                header('Location: admin.html?mensaje=plato_eliminado');
                exit;
            } else {
                echo "Error al eliminar plato.";
            }
        } else {
            echo "Datos inválidos para eliminar.";
        }
    }

    if (isset($_POST['editar'])) {
        if ($nombreNuevo && $nombre && $tipo && $precio) {
            if ($admin->editarPlato($nombreNuevo, $nombre, $tipo, $precio)) {
                header('Location: admin.html?mensaje=plato_editado');
                exit;
            } else {
                echo "Error al editar plato.";
            }
        } else {
            echo "Datos inválidos para editar.";
        }
    }
}
?>
