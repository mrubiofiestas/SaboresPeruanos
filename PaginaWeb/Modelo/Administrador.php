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

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("INSERT INTO platos (nombre_plato, tipo, precio) VALUES (:nombre, :tipo, :precio)");
            $consulta->bindParam(":nombre", $nombre_plato);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->bindParam(":precio", $precio);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "Error al agregar plato: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarPlato($nombre_plato)
    {
        $nombre_plato = validar_texto($nombre_plato);

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("DELETE FROM platos WHERE nombre_plato = :nombre");
            $consulta->bindParam(":nombre", $nombre_plato);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar plato: " . $e->getMessage();
            return false;
        }
    }

    public function editarPlato($nombre_plato_original, $nuevo_nombre, $nuevo_tipo, $nuevo_precio)
    {
        $nombre_plato_original = validar_texto($nombre_plato_original);
        $nuevo_nombre = validar_texto($nuevo_nombre);
        $nuevo_tipo = validar_texto($nuevo_tipo);
        $nuevo_precio = validarPrecio($nuevo_precio);

        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("UPDATE platos 
                SET nombre_plato = :nuevo_nombre, tipo = :nuevo_tipo, precio = :nuevo_precio 
                WHERE nombre_plato = :original");
            $consulta->bindParam(":nuevo_nombre", $nuevo_nombre);
            $consulta->bindParam(":nuevo_tipo", $nuevo_tipo);
            $consulta->bindParam(":nuevo_precio", $nuevo_precio);
            $consulta->bindParam(":original", $nombre_plato_original);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "Error al editar plato: " . $e->getMessage();
            return false;
        }
    }
}
