<?php 
class Usuario {
    private $email;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $clave;
    private $id_rol;

    public function __construct($email, $nombre, $apellidos, $direccion, $clave, $id_rol) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccion = $direccion;
        $this->clave = $clave;
        $this->id_rol = $id_rol;
    }

    public function crearUsuario() {
        $salida = false;
        if (!self::buscarUsuario($this->email)) {
            try {
                //Quiza pueda cambiar la manera en la que conecto la base de datos para que sea menos codigo
                $conexion = new Conexion("sabores_peruanos","localhost", "root", "");
                $crearUsuario = $conexion->getConexion()->prepare("insert into usuario (email, nombre, apellidos, direccion, clave, id_rol) 
                values (:email, :nombre, :apellidos, :direccion, :clave, :id_rol)");
                $crearUsuario->bindParam(":email", $this->email);
                $crearUsuario->bindParam(":nombre", $this->nombre);
                $crearUsuario->bindParam(":apellidos", $this->apellidos);
                $crearUsuario->bindParam(":direccion", $this->direccion);
                $crearUsuario->bindParam(":clave", $this->clave);
                $crearUsuario->bindParam(":id_rol", $this->id_rol);
                $resultado = $crearUsuario->execute();
                $salida = true;
            }catch (PDOException $e) {
                $salida = false;
            } 
        }else {
            $salida = false; 
        }
        return $salida;
    }


    public static function buscarUsuario($email) {
        $salida = false;
        if (!is_null($email)) {
            try {
                $conexion = new Conexion("sabores_peruanos", "localhost", "root", "");
                $buscarUsuario = $conexion->getConexion()->prepare("select * from usuario where email = :email");
                $buscarUsuario->bindParam(":email", $email);
                $buscarUsuario->execute();
                $resultado = $buscarUsuario->fetch(PDO::FETCH_ASSOC);
                if ($resultado) {
                    $salida = $resultado;
                }
            } catch (PDOException $e) {
                $salida = false;
            }
        }
        return $salida;
    }

}