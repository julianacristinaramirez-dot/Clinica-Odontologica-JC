<?php
require_once __DIR__ . '/../config/database.php';

class Servicio {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }
    public function listar() {
        $stmt = $this->conn->prepare("SELECT * FROM servicios ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>