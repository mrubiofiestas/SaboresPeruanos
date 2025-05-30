<?php
/**
 * Clase Usuario
 * Esta clase sirve para manejar todo lo de los usuarios: crearlos y buscarlos en la base de datos.
 * Así puedes registrar y buscar usuarios facilmente.
 * 
 * @author Milagros del Rosario Rubio Fiestas
 * @version 1.0
 * @package Modelo
 */

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

    /**
     * Crea un nuevo objeto Usuario.
     *
     * @param string $email El correo del usuario.
     * @param string $nombre El nombre del usuario.
     * @param string $apellidos Los apellidos del usuario.
     * @param string $direccion La dirección del usuario.
     * @param string $clave La clave.
     * @param int $id_rol El rol del usuario (por defecto 2 para usuarios normales).
     */
    public function __construct($email, $nombre, $apellidos, $direccion, $clave, $id_rol)
    {
        $this->email = validarEmail($email);
        $this->nombre = validarNombre($nombre);
        $this->apellidos = validarApellidos($apellidos);
        $this->direccion = validarDireccion($direccion);
        $this->clave = $clave;
        $this->id_rol = $id_rol;
    }

    /**
     * Crea un usuario nuevo en la base de datos.
     * Solo lo crea si no existe ya un usuario con ese correo.
     *
     * @return bool True si lo creó, false si ya existe o hubo error.
     */
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

    /**
     * Busca un usuario por su correo.
     *
     * @param string $email El correo del usuario a buscar.
     * @return array|false Los datos del usuario si existe, o false si no lo encuentra.
     */
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
