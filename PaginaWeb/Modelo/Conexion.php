<?php

class Conexion {
    private $mibd;
    private $host;
    private $usuario;
    private $clave;
    private $conexion;

    public function __construct($mibd, $host, $usuario, $clave = '') {
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

    public function getConexion()
    {
        return $this->conexion;
    }
}
