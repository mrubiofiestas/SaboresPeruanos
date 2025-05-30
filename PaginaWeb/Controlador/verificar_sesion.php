<?php
/**
 * Este archivo sirve para chequear si el usuario está logueado o no.
 * Devuelve en JSON si hay sesión activa, el nombre y el rol del usuario (si hay).
 * Es para asegurarse que un usuario invitado no pueda comprar, solo usuarios logueados.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

session_start();

header('Content-Type: application/json');

echo json_encode([
    'logueado' => isset($_SESSION['email']),
    'nombre' => $_SESSION['nombre'] ?? '',
    'rol' => $_SESSION['rol'] ?? ''
]);