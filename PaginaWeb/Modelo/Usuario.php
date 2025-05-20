<?php
require_once 'Conexion.php';
require_once 'validaciones.php';

class Usuario
{
    private $email;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $clave;
    private $id_rol;

    public function __construct($email, $nombre, $apellidos, $direccion, $clave, $id_rol)
    {
        $this->email = validarEmail($email);
        $this->nombre = validarNombre($nombre);
        $this->apellidos = validarApellidos($apellidos);
        $this->direccion = validarDireccion($direccion);
        $this->clave = $clave;
        $this->id_rol = $id_rol;
    }

    public function crearUsuario()
    {
        $salida = false;
        if (!Usuario::buscarUsuario($this->email)) {
            try {
                $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
                $consulta = $conexion->getConexion()->prepare("INSERT INTO usuario 
                    (email, nombre, apellidos, direccion, clave, id_rol) 
                    VALUES (:email, :nombre, :apellidos, :direccion, :clave, :id_rol)");
                
                $consulta->bindParam(":email", $this->email);
                $consulta->bindParam(":nombre", $this->nombre);
                $consulta->bindParam(":apellidos", $this->apellidos);
                $consulta->bindParam(":direccion", $this->direccion);
                $consulta->bindParam(":clave", $this->clave);
                $consulta->bindParam(":id_rol", $this->id_rol);
                
                $consulta->execute();
                $salida = true;
            } catch (PDOException $e) {
                die("Error al crear nuevo usuario: " . $e->getMessage());
            }
        }
        return $salida;
    }

    public static function buscarUsuario($email)
    {
        $salida = false;
        $email = validarEmail($email);
        if (!is_null($email)) {
            try {
                $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
                $consulta = $conexion->getConexion()->prepare("SELECT * FROM usuario WHERE email = :email");
                $consulta->bindParam(":email", $email);
                $consulta->execute();
                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                if ($resultado) {
                    $salida = $resultado;
                }
            } catch (PDOException $e) {
                echo "Error al buscar el usuario: " . $e->getMessage();
            }
        }
        return $salida;
    }
}
