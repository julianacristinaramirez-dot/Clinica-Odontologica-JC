<?php
require_once __DIR__ . '/../model/Tratamiento.php';
require_once __DIR__ . '/../model/Cita.php';
require_once __DIR__ . '/../model/Servicio.php'; 

class TratamientoController {
    private $modelo;
    private $modeloCita;
    private $modeloServicio;

    public function __construct() {
        $this->modelo = new Tratamiento();
        $this->modeloCita = new Cita();
        $this->modeloServicio = new Servicio(); 
    }

    public function listarTratamientos() { return $this->modelo->listar(); }
    public function listarCitas() { return $this->modeloCita->listar(); }
    public function listarServicios() { return $this->modeloServicio->listar(); }
    public function obtenerTratamiento($id) { return $this->modelo->obtenerPorId($id); }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            if ($accion === 'eliminar') {
                $this->modelo->eliminar($_POST['id'] ?? 0);
                header("Location: tratamientos.php?mensaje=eliminado");
                exit;
            }
            if ($accion === 'guardar' || $accion === 'actualizar') {
                $id = $_POST['id'] ?? null;
                $id_cita = $_POST['id_cita'] ?? '';
                $id_servicio = $_POST['id_servicio'] ?? '';
                $diagnostico = $_POST['diagnostico'] ?? '';
                $observaciones = $_POST['observaciones'] ?? '';

                if ($accion === 'actualizar' && $id) {
                    $this->modelo->actualizar($id, $id_cita, $id_servicio, $diagnostico, $observaciones);
                    header("Location: tratamientos.php?mensaje=actualizado");
                } else {
                    $this->modelo->guardar($id_cita, $id_servicio, $diagnostico, $observaciones);
                    header("Location: tratamientos.php?mensaje=guardado");
                }
                exit;
            }
        }
    }
}
?>