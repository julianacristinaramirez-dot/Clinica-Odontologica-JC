<?php
require_once __DIR__ . '/../config/database.php';

class Cita {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listar() {
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, o.nombre AS odontologo_nombre 
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id
                INNER JOIN odontologos o ON c.id_odontologo = o.id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function guardar($id_paciente, $id_odontologo, $fecha, $hora, $estado) {
        $sql = "INSERT INTO citas (id_paciente, id_odontologo, fecha, hora, estado) 
                VALUES (:id_paciente, :id_odontologo, :fecha, :hora, :estado)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_paciente' => $id_paciente,
            ':id_odontologo' => $id_odontologo,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':estado' => $estado
        ]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM citas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function actualizar($id, $id_paciente, $id_odontologo, $fecha, $hora, $estado) {
        $sql = "UPDATE citas 
                SET id_paciente = :id_paciente, id_odontologo = :id_odontologo, 
                    fecha = :fecha, hora = :hora, estado = :estado
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':id_paciente' => $id_paciente,
            ':id_odontologo' => $id_odontologo,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':estado' => $estado
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM citas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>