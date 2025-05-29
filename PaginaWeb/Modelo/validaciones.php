<?php
function validar_texto($campo) {
    if (!is_string($campo)) return '';
    $campo = trim($campo);
    $campo = strip_tags($campo);
    $campo = htmlspecialchars($campo, ENT_QUOTES);
    $campo = str_replace('+', '', $campo);
    return $campo;
}


function validarEmail($email) {
    $email = validar_texto($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return $email;
}

function validarNombre($campo) {
    $campo = validar_texto($campo);
    return !empty($campo) ? $campo : false;
}

function validarApellidos($apellidos) {
    $apellidos = validar_texto($apellidos);
    return !empty($apellidos) ? $apellidos : false;
}

function validarDireccion($direccion) {
    $direccion = validar_texto($direccion);
    return !empty($direccion) ? $direccion : false;
}

function validarClave($clave) {
    if (strlen($clave) < 8 || !preg_match('/[A-Z]/', $clave) || !preg_match('/[0-9]/', $clave)) {
        return false;
    }
    return $clave;
}
function validarPrecio($precio)
{
    $precio = trim($precio);
    $precio = str_replace(',', '.', $precio);
    if (is_numeric($precio) && floatval($precio) > 0) {
        return number_format((float)$precio, 2, '.', '');
    } else {
        return null;
    }
}
?>