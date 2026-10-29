<?php
require_once __DIR__ . '/../model/Servicio.php';

class ServicioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Servicio();
    }

    public function listarServicios() {
        return $this->modelo->listar();
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../config/database.php';
            $db = new Database();
            $conn = $db->conectar();
            
            $accion = $_POST['accion'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $id = $_POST['id'] ?? 0;

            if ($accion === 'guardar') {
                $stmt = $conn->prepare("INSERT INTO servicios (nombre, precio) VALUES (:nombre, :precio)");
                $stmt->execute([':nombre' => $nombre, ':precio' => $precio]);
                header("Location: servicios.php?mensaje=guardado");
                exit;
            }
            if ($accion === 'actualizar') {
                $stmt = $conn->prepare("UPDATE servicios SET nombre = :nombre, precio = :precio WHERE id = :id");
                $stmt->execute([':nombre' => $nombre, ':precio' => $precio, ':id' => $id]);
                header("Location: servicios.php?mensaje=actualizado");
                exit;
            }
            if ($accion === 'eliminar') {
                $stmt = $conn->prepare("DELETE FROM servicios WHERE id = :id");
                $stmt->execute([':id' => $id]);
                header("Location: servicios.php?mensaje=eliminado");
                exit;
            }
        }
    }

    public function obtenerServicio($id) {
        require_once __DIR__ . '/../config/database.php';
        $db = new Database();
        $conn = $db->conectar();
        $stmt = $conn->prepare("SELECT * FROM servicios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
?>