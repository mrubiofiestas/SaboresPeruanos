<?php
/**
 * Este archivo se encarga de sacar todas las comandas que están "pendientes".
 * Llama al modelo para traerlas y las devuelve en formato JSON.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Controlador
 */

require_once '../Modelo/Comandas.php';

session_start();

// Obtiene todas las comandas con estado "pendiente"
$comandas = Comanda::obtenerTodas('pendiente');

header('Content-Type: application/json');
echo json_encode($comandas);