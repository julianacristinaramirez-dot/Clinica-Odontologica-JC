<?php
require_once __DIR__ . '/../config/database.php';

class Reporte {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // 1. Total de ingresos (Suma de todos los pagos)
    public function totalIngresos() {
        $stmt = $this->conn->query("SELECT SUM(monto) AS total FROM pagos");
        $resultado = $stmt->fetch();
        return $resultado['total'] ?? 0;
    }

    // 2. Total de citas pendientes (Para el reporte de citas pendientes)
    public function totalCitasPendientes() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM citas WHERE estado = 'Pendiente'");
        $resultado = $stmt->fetch();
        return $resultado['total'] ?? 0;
    }

    // 3. Reporte de atenciones realizadas (Tratamientos y Citas)
    public function atencionesRealizadas() {
        $sql = "SELECT c.fecha, pa.nombre AS paciente, o.nombre AS odontologo, c.estado, 
                IFNULL(t.diagnostico, 'Sin diagnóstico') AS diagnostico
                FROM citas c
                INNER JOIN pacientes pa ON c.id_paciente = pa.id
                INNER JOIN odontologos o ON c.id_odontologo = o.id
                LEFT JOIN tratamientos t ON c.id = t.id_cita
                WHERE c.estado = 'Atendida'
                ORDER BY c.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 4. Reporte de ingresos por método de pago
    public function ingresosPorMetodo() {
        $sql = "SELECT metodo_pago, SUM(monto) AS total 
                FROM pagos 
                GROUP BY metodo_pago";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>