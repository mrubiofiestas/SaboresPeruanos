<?php
/**
 * Este archivo se encarga de sacar todos los platos de la base de datos y devolverlos en formato JSON.
 * Sirve para que el frontend pueda mostrar la lista de platos fácil y rápido.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Plato.php';

header('Content-Type: application/json');
$platos = Plato::obtenerTodos();
echo json_encode($platos);