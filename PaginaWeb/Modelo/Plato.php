<?php
require_once 'Conexion.php';
require_once 'validaciones.php';

class Plato
{
    private $nombre;
    private $tipo;
    private $precio;

    public function __construct($nombre, $tipo, $precio)
    {
        $this->nombre = validar_Texto($nombre);
        $this->tipo = validar_Texto($tipo);
        $this->precio = filter_var($precio, FILTER_VALIDATE_FLOAT);
    }

    public static function obtenerTodos()
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->query("SELECT * FROM platos");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener platos: " . $e->getMessage());
        }
    }

    public function agregarPlato()
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("INSERT INTO platos (nombre_plato, tipo, precio) VALUES (:nombre, :tipo, :precio)");
            $consulta->bindParam(":nombre", $this->nombre);
            $consulta->bindParam(":tipo", $this->tipo);
            $consulta->bindParam(":precio", $this->precio);
            return $consulta->execute();
        } catch (PDOException $e) {
            die("Error al agregar plato: " . $e->getMessage());
        }
    }

    public function editarPlato($nombreOriginal)
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("UPDATE platos SET nombre_plato = :nuevoNombre, tipo = :tipo, precio = :precio WHERE nombre_plato = :nombreOriginal");
            $consulta->bindParam(":nuevoNombre", $this->nombre);
            $consulta->bindParam(":tipo", $this->tipo);
            $consulta->bindParam(":precio", $this->precio);
            $consulta->bindParam(":nombreOriginal", $nombreOriginal);
            return $consulta->execute();
        } catch (PDOException $e) {
            die("Error al editar plato: " . $e->getMessage());
        }
    }

    public static function eliminarPlato($nombre)
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("DELETE FROM platos WHERE nombre_plato = :nombre");
            $consulta->bindParam(":nombre", $nombre);
            return $consulta->execute();
        } catch (PDOException $e) {
            die("Error al eliminar plato: " . $e->getMessage());
        }
    }
}
