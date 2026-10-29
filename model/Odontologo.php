<?php
require_once __DIR__ . '/../config/database.php';

class Odontologo {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM odontologos ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function guardar($nombre, $especialidad, $telefono, $correo) {
        $sql = "INSERT INTO odontologos (nombre, especialidad, telefono, correo) 
                VALUES (:nombre, :especialidad, :telefono, :correo)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':especialidad' => $especialidad,
            ':telefono' => $telefono,
            ':correo' => $correo
        ]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM odontologos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function actualizar($id, $nombre, $especialidad, $telefono, $correo) {
        $sql = "UPDATE odontologos 
                SET nombre = :nombre, especialidad = :especialidad, telefono = :telefono, correo = :correo
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':especialidad' => $especialidad,
            ':telefono' => $telefono,
            ':correo' => $correo
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM odontologos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>