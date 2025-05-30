<?php
/**
 * Clase Comanda
 * Maneja la gestión de las comandas: ver todas, actualizar estado, etc.
 * No se eliminan registros, solo se actualiza el estado.
 *
 * @author Milagros
 * @version 1.0
 * @package Modelo
 */

require_once 'Conexion.php';

class Comanda
{
    /**
     * Obtiene todas las comandas, con estado opcional (pendiente/lista).
     *
     * @param string|null $estado El estado opcional de las comandas (pendiente, lista).
     * @return array Lista de comandas.
     */
    public static function obtenerTodas($estado = null)
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");

            if ($estado) {
                $consulta = $conexion->getConexion()->prepare("SELECT * FROM comandas WHERE estado = :estado ORDER BY fecha DESC");
                $consulta->bindParam(":estado", $estado);
                $consulta->execute();
            } else {
                $consulta = $conexion->getConexion()->query("SELECT * FROM comandas ORDER BY fecha DESC");
            }

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener comandas: " . $e->getMessage());
        }
    }

    /**
     * Marca una comanda como lista (cambia su estado).
     *
     * @param int $idComanda ID de la comanda.
     * @return bool True si se actualizó correctamente.
     */
    public static function marcarComoLista($idComanda)
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");

            $consulta = $conexion->getConexion()->prepare("UPDATE comandas SET estado = 'lista' WHERE id = :id");
            $consulta->bindParam(":id", $idComanda);
            $consulta->execute();

            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            die("Error al actualizar comanda: " . $e->getMessage());
        }
    }
}
