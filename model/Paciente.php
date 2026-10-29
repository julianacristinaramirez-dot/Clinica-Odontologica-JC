<?php
require_once __DIR__ . '/../config/database.php';

class Paciente {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM pacientes ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function guardar($nombre, $dni, $telefono, $correo, $direccion, $fecha_nacimiento) {
        $sql = "INSERT INTO pacientes (nombre, dni, telefono, correo, direccion, fecha_nacimiento) 
                VALUES (:nombre, :dni, :telefono, :correo, :direccion, :fecha_nacimiento)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':dni' => $dni,
            ':telefono' => $telefono,
            ':correo' => $correo,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento
        ]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM pacientes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function actualizar($id, $nombre, $dni, $telefono, $correo, $direccion, $fecha_nacimiento) {
        $sql = "UPDATE pacientes 
                SET nombre = :nombre, dni = :dni, telefono = :telefono, 
                    correo = :correo, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':dni' => $dni,
            ':telefono' => $telefono,
            ':correo' => $correo,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento
        ]);
    }

    // ELIMINAR (Borrar)
    public function eliminar($id) {
        $sql = "DELETE FROM pacientes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>