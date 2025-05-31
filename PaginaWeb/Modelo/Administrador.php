<?php
/**
 * Clase Administrador
 * Esta clase sirve para que el admin pueda agregar, eliminar y editar platos en la base de datos.
 * Valida los datos antes de hacer cualquier cosa para evitar problemas.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @version 1.0
 * @package Modelo
 */

require_once 'Conexion.php';
require_once 'validaciones.php';

class Administrador
{
    /**
     * Agrega un plato nuevo a la base de datos.
     * Valida los datos antes de guardarlos.
     *
     * @param string $nombre_plato El nombre del plato.
     * @param string $tipo El tipo de plato (ej: entrada, fondo, postre).
     * @param float $precio El precio del plato.
     * @return bool True si todo salió bien, false si hubo error.
     */
    public function agregarPlato($nombre_plato, $tipo, $precio)
    {
        $salida = false;
        $nombre_plato = validar_texto($nombre_plato);
        $tipo = validar_texto($tipo);
        $precio = validarPrecio($precio);

        if (!$nombre_plato || !$tipo || $precio === false) {
            return $salida;
        }

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare(
                "INSERT INTO platos (nombre_plato, tipo, precio) VALUES (:nombre, :tipo, :precio)"
            );
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->bindParam(":precio", $precio);
            $salida = $consulta->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar plato: " . $e->getMessage());
            $salida = false;
        }
        return $salida;
    }

    /**
     * Elimina un plato de la base de datos por su nombre.
     * 
     * @param string $nombre_plato El nombre del plato a borrar.
     * @return bool True si lo borró, false si falló.
     */
    public function eliminarPlato($nombre_plato)
    {
        $salida = false;
        $nombre_plato = validar_texto($nombre_plato);
        if (!$nombre_plato) {
            return $salida;
        }

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare(
                "DELETE FROM platos WHERE nombre_plato = :nombre"
            );
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->execute();
            $salida = $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al eliminar plato: " . $e->getMessage());
            $salida = false;
        }
        return $salida;
    }

    /**
     * Edita los datos de un plato ya existente.
     * 
     * @param string $nombre_plato El nombre del plato a editar.
     * @param string $tipo El nuevo tipo de plato.
     * @param float $precio El nuevo precio.
     * @return bool True si lo editó, false si falló.
     */
    public function editarPlato($nombre_plato, $tipo, $precio)
    {
        $salida = false;
        $nombre_plato = validar_texto($nombre_plato);
        $tipo = validar_texto($tipo);
        $precio = validarPrecio($precio);

        if (!$nombre_plato || !$tipo || $precio === false) {
            return $salida;
        }

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare(
                "UPDATE platos SET tipo = :tipo, precio = :precio WHERE nombre_plato = :nombre"
            );
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->bindParam(":precio", $precio);
            $consulta->execute();
            $salida = $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al editar plato: " . $e->getMessage());
            $salida = false;
        }
        return $salida;
    }
}