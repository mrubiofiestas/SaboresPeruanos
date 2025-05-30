<?php

/**
 * Funciones de validación
 * Estas son las funciones para validar y limpiar los datos que entran al sistema.
 * Así es seguro de que no se meta nada raro..
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @package Modelo
 */

/**
 * Limpia y valida un texto para que no tenga cosas raras.
 *
 * @param string $campo El texto a limpiar.
 * @return string El texto limpio.
 */
function validar_texto($campo)
{
    if (!is_string($campo)) return '';
    $campo = trim($campo);
    $campo = strip_tags($campo);
    $campo = htmlspecialchars($campo, ENT_QUOTES);
    $campo = str_replace('+', '', $campo);
    return $campo;
}

/**
 * Valida que el email tenga formato correcto.
 *
 * @param string $email El email a validar.
 * @return string|false El email si está bien, false si no.
 */
function validarEmail($email)
{
    $email = validar_texto($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return $email;
}

/**
 * Valida que el nombre no esté vacío y lo limpia.
 *
 * @param string $campo El nombre a validar.
 * @return string|false El nombre si está bien, false si no.
 */
function validarNombre($campo)
{
    $campo = validar_texto($campo);
    return !empty($campo) ? $campo : false;
}

/**
 * Valida los apellidos.
 *
 * @param string $apellidos Los apellidos a validar.
 * @return string|false Los apellidos si están bien, false si no.
 */
function validarApellidos($apellidos)
{
    $apellidos = validar_texto($apellidos);
    return !empty($apellidos) ? $apellidos : false;
}

/**
 * Valida la dirección.
 *
 * @param string $direccion La dirección a validar.
 * @return string|false La dirección si está bien, false si no.
 */
function validarDireccion($direccion)
{
    $direccion = validar_texto($direccion);
    return !empty($direccion) ? $direccion : false;
}

/**
 * Valida la clave: mínimo 8 caracteres, una mayúscula y un número.
 *
 * @param string $clave La clave a validar.
 * @return string|false La clave si está bien, false si no.
 */
function validarClave($clave)
{
    if (strlen($clave) < 6 || !preg_match('/[A-Z]/', $clave) || !preg_match('/[0-9]/', $clave)) {
        return false;
    }
    return $clave;
}

/**
 * Valida el precio: que sea un número y mayor a 0.
 *
 * @param mixed $precio El precio a validar.
 * @return string|null El precio formateado si está bien, null si no.
 */
function validarPrecio($precio)
{
    $precio = trim($precio);
    if (!is_numeric($precio) || $precio < 0) {
        return false;
    }
    return floatval($precio);
}
