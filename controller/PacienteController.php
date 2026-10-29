<?php
require_once __DIR__ . '/../model/Paciente.php';

class PacienteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Paciente();
    }

    public function listarPacientes() {
        return $this->modelo->listar();
    }

    public function obtenerPaciente($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'eliminar') {
                $id = $_POST['id'] ?? 0;
                $this->modelo->eliminar($id);
                header("Location: pacientes.php?mensaje=eliminado");
                exit;
            }

            if ($accion === 'guardar' || $accion === 'actualizar') {
                $id = $_POST['id'] ?? null;
                $nombre = $_POST['nombre'] ?? '';
                $dni = $_POST['dni'] ?? '';
                $telefono = $_POST['telefono'] ?? '';
                $correo = $_POST['correo'] ?? '';
                $direccion = $_POST['direccion'] ?? '';
                $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

                if ($accion === 'actualizar' && $id) {
                    $this->modelo->actualizar($id, $nombre, $dni, $telefono, $correo, $direccion, $fecha_nacimiento);
                    header("Location: pacientes.php?mensaje=actualizado");
                } else {
                    $this->modelo->guardar($nombre, $dni, $telefono, $correo, $direccion, $fecha_nacimiento);
                    header("Location: pacientes.php?mensaje=guardado");
                }
                exit;
            }
        }
    }
}
?>