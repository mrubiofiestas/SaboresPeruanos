<?php
/**
 * Clase Conexion
 * Esta clase se encarga de conectar con la base de datos usando PDO.
 * Así se pueden hacer consultas sin preocuparte por la conexión cada vez.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @version 1.0
 * @package Modelo
 */
class Conexion
{
    private $mibd;
    private $host;
    private $usuario;
    private $clave;
    private $conexion;

    /**
     * Crea una nueva conexión a la base de datos.
     *
     * @param string $mibd El nombre de la base de datos (en este caso 'sabores_peruanos').
     * @param string $host El host donde está la base (en este caso 'db').
     * @param string $usuario El usuario para conectarse (en este caso 'root').
     * @param string $clave La clave del usuario.
     */
    public function __construct($mibd, $host, $usuario, $clave)
    {
        $this->mibd = $mibd;
        $this->host = $host;
        $this->usuario = $usuario;
        $this->clave = $clave;
        try {
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->mibd}", $this->usuario, $this->clave);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * Devuelve la conexión PDO lista para usar.
     *
     * @return PDO La conexión a la base de datos.
     */
    public function getConexion()
    {
        return $this->conexion;
    }
}