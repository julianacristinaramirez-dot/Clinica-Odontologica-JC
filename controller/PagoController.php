<?php
require_once __DIR__ . '/../model/Pago.php';
require_once __DIR__ . '/../model/Cita.php'; 

class PagoController {
    private $modelo;
    private $modeloCita;

    public function __construct() {
        $this->modelo = new Pago();
        $this->modeloCita = new Cita();
    }

    public function listarPagos() {
        return $this->modelo->listar();
    }

    public function listarCitas() {
        return $this->modeloCita->listar();
    }

    public function obtenerPago($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'eliminar') {
                $id = $_POST['id'] ?? 0;
                $this->modelo->eliminar($id);
                header("Location: pagos.php?mensaje=eliminado");
                exit;
            }

            if ($accion === 'guardar' || $accion === 'actualizar') {
                $id = $_POST['id'] ?? null;
                $id_cita = $_POST['id_cita'] ?? '';
                $monto = $_POST['monto'] ?? '';
                $metodo_pago = $_POST['metodo_pago'] ?? '';

                if ($accion === 'actualizar' && $id) {
                    $this->modelo->actualizar($id, $id_cita, $monto, $metodo_pago);
                    header("Location: pagos.php?mensaje=actualizado");
                } else {
                    $this->modelo->guardar($id_cita, $monto, $metodo_pago);
                    header("Location: pagos.php?mensaje=guardado");
                }
                exit;
            }
        }
    }
}
?>