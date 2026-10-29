<?php
require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function login($correo, $clave) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Si la clave en la BD es igual a la que escribió el usuario (texto plano)
            // (Recuerda que en el SQL dejamos la clave como '12345')
            if ($clave === $usuario['clave']) {
                return $usuario;
            }
        }
        return null;
    }
}
?>