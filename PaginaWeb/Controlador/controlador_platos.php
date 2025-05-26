<?php
require_once '../Modelo/Plato.php';

header('Content-Type: application/json');
$platos = Plato::obtenerTodos();
echo json_encode($platos);