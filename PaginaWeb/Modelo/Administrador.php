<?php
require_once 'Conexion.php';
require_once 'validaciones.php';

class Administrador
{
    public function agregarPlato($nombre_plato, $tipo, $precio)
    {
        $nombre_plato = validar_texto($nombre_plato);
        $tipo = validar_texto($tipo);
        $precio = validarPrecio($precio);

        if (!$nombre_plato || !$tipo || $precio === false) return false;

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare(
                "INSERT INTO platos (nombre_plato, tipo, precio) VALUES (:nombre, :tipo, :precio)"
            );
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->bindParam(":precio", $precio);
            return $consulta->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar plato: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarPlato($nombre_plato)
    {
        $nombre_plato = validar_texto($nombre_plato);
        if (!$nombre_plato) return false;

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare(
                "DELETE FROM platos WHERE nombre_plato = :nombre"
            );
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->execute();
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al eliminar plato: " . $e->getMessage());
            return false;
        }
    }

    public function editarPlato($nombre_plato, $tipo, $precio)
    {
        $nombre_plato = validar_texto($nombre_plato);
        $tipo = validar_texto($tipo);
        $precio = validarPrecio($precio);

        if (!$nombre_plato || !$tipo || $precio === false) return false;

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare(
                "UPDATE platos SET tipo = :tipo, precio = :precio WHERE nombre_plato = :nombre"
            );
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->bindParam(":precio", $precio);
            $consulta->execute();
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al editar plato: " . $e->getMessage());
            return false;
        }
    }
}
