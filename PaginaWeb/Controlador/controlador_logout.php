<?php
/**
 * Este archivo se encarga de cerrar la sesión del usuario.
 * Básicamente borra todo lo de la sesión y manda al usuario al inicio.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

session_start(); // Arranca la sesión por si acaso
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión por completo
header("Location: ../index.html"); // Redirige al usuario a la página principal
exit();
