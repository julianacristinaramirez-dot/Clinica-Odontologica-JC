<?php
require_once __DIR__ . '/../config/database.php';

class Pago {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listar() {
        $sql = "SELECT p.*, c.fecha AS cita_fecha, pa.nombre AS paciente_nombre 
                FROM pagos p
                INNER JOIN citas c ON p.id_cita = c.id
                INNER JOIN pacientes pa ON c.id_paciente = pa.id
                ORDER BY p.fecha_pago DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function guardar($id_cita, $monto, $metodo_pago) {
        $sql = "INSERT INTO pagos (id_cita, monto, metodo_pago) 
                VALUES (:id_cita, :monto, :metodo_pago)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_cita' => $id_cita,
            ':monto' => $monto,
            ':metodo_pago' => $metodo_pago
        ]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM pagos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function actualizar($id, $id_cita, $monto, $metodo_pago) {
        $sql = "UPDATE pagos 
                SET id_cita = :id_cita, monto = :monto, metodo_pago = :metodo_pago
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':id_cita' => $id_cita,
            ':monto' => $monto,
            ':metodo_pago' => $metodo_pago
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM pagos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>