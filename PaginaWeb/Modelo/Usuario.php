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
            // Encriptar la clave antes de insertar
            $this->clave = password_hash($this->clave, PASSWORD_DEFAULT);

            $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
            $pdo = $conexion->getConexion();

            $crearUsuario = $pdo->prepare("
                INSERT INTO usuario (email, nombre, apellidos, direccion, clave, id_rol) 
                VALUES (:email, :nombre, :apellidos, :direccion, :clave, :id_rol)
            ");

            $crearUsuario->bindParam(":email", $this->email);
            $crearUsuario->bindParam(":nombre", $this->nombre);
            $crearUsuario->bindParam(":apellidos", $this->apellidos);
            $crearUsuario->bindParam(":direccion", $this->direccion);
            $crearUsuario->bindParam(":clave", $this->clave);
            $crearUsuario->bindParam(":id_rol", $this->id_rol);

            $crearUsuario->execute();
            $salida = true;
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            $salida = false;
        }
    }

    return $salida;
}

    public static function buscarUsuario($email) {
        $salida = false;
        if (!empty($email)) {
            try {
                $conexion = new Conexion("sabores_peruanos", "db", "root", "clave");
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