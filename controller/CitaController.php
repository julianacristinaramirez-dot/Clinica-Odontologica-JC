<?php
require_once __DIR__ . '/../model/Cita.php';
require_once __DIR__ . '/../model/Paciente.php';
require_once __DIR__ . '/../model/Odontologo.php';

class CitaController {
    private $modelo;
    private $modeloPaciente;
    private $modeloOdontologo;

    public function __construct() {
        $this->modelo = new Cita();
        $this->modeloPaciente = new Paciente();
        $this->modeloOdontologo = new Odontologo();
    }

    public function listarCitas() {
        return $this->modelo->listar();
    }

    // Para llenar los <select> del formulario
    public function listarPacientes() {
        return $this->modeloPaciente->listar();
    }

    public function listarOdontologos() {
        return $this->modeloOdontologo->listar();
    }

    public function obtenerCita($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'eliminar') {
                $id = $_POST['id'] ?? 0;
                $this->modelo->eliminar($id);
                header("Location: citas.php?mensaje=eliminado");
                exit;
            }

            if ($accion === 'guardar' || $accion === 'actualizar') {
                $id = $_POST['id'] ?? null;
                $id_paciente = $_POST['id_paciente'] ?? '';
                $id_odontologo = $_POST['id_odontologo'] ?? '';
                $fecha = $_POST['fecha'] ?? '';
                $hora = $_POST['hora'] ?? '';
                $estado = $_POST['estado'] ?? 'Pendiente';

                if ($accion === 'actualizar' && $id) {
                    $this->modelo->actualizar($id, $id_paciente, $id_odontologo, $fecha, $hora, $estado);
                    header("Location: citas.php?mensaje=actualizado");
                } else {
                    $this->modelo->guardar($id_paciente, $id_odontologo, $fecha, $hora, $estado);
                    header("Location: citas.php?mensaje=guardado");
                }
                exit;
            }
        }
    }
}
?>