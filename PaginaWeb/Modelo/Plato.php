<?php
/**
 * Clase Plato
 * Esta clase sirve para manejar todo lo relacionado a los platos: crearlos, editarlos, borrarlos y listarlos.
 * Así puedes trabajar con los platos de la base de datos sin complicarte la vida.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @version 1.0
 * @package Modelo
 */

require_once 'Conexion.php';
require_once 'validaciones.php';

class Plato
{
    private $nombre;
    private $tipo;
    private $precio;

    /**
     * Crea un nuevo objeto Plato.
     *
     * @param string $nombre El nombre del plato.
     * @param string $tipo El tipo de plato.
     * @param float $precio El precio del plato.
     */
    public function __construct($nombre, $tipo, $precio)
    {
        $this->nombre = validar_Texto($nombre);
        $this->tipo = validar_Texto($tipo);
        $this->precio = filter_var($precio, FILTER_VALIDATE_FLOAT);
    }

    /**
     * Saca todos los platos de la base de datos.
     *
     * @return array Lista de platos (cada uno como array asociativo).
     */
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

    /**
     * Agrega este plato a la base de datos.
     *
     * @return bool True si todo ok, false si falló.
     */
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

    /**
     * Edita los datos de un plato ya existente.
     *
     * @param string $nombreOriginal El nombre actual del plato que quieres editar.
     * @return bool True si lo editó, false si falló.
     */
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

    /**
     * Borra un plato de la base de datos por su nombre.
     *
     * @param string $nombre El nombre del plato a borrar.
     * @return bool True si lo borró, false si falló.
     */
    public static function eliminarPlato($nombre)
    {
        try {
            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $consulta = $conexion->getConexion()->prepare("DELETE FROM platos WHERE nombre_plato = :nombre");
            $consulta->bindParam(":nombre", $nombre);
            $consulta->execute();
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            die("Error al eliminar plato: " . $e->getMessage());
        }
    }
}
