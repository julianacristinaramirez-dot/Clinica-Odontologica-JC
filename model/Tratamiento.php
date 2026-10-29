<?php
require_once __DIR__ . '/../config/database.php';

class Tratamiento {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listar() {
        $sql = "SELECT t.*, c.fecha AS cita_fecha, p.nombre AS paciente_nombre, s.nombre AS servicio_nombre 
                FROM tratamientos t
                INNER JOIN citas c ON t.id_cita = c.id
                INNER JOIN pacientes p ON c.id_paciente = p.id
                INNER JOIN servicios s ON t.id_servicio = s.id
                ORDER BY t.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function guardar($id_cita, $id_servicio, $diagnostico, $observaciones) {
        $sql = "INSERT INTO tratamientos (id_cita, id_servicio, diagnostico, observaciones) 
                VALUES (:id_cita, :id_servicio, :diagnostico, :observaciones)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_cita' => $id_cita,
            ':id_servicio' => $id_servicio,
            ':diagnostico' => $diagnostico,
            ':observaciones' => $observaciones
        ]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM tratamientos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function actualizar($id, $id_cita, $id_servicio, $diagnostico, $observaciones) {
        $sql = "UPDATE tratamientos SET id_cita = :id_cita, id_servicio = :id_servicio, diagnostico = :diagnostico, observaciones = :observaciones WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':id_cita' => $id_cita,
            ':id_servicio' => $id_servicio,
            ':diagnostico' => $diagnostico,
            ':observaciones' => $observaciones
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM tratamientos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>