<?php
require_once __DIR__ . '/../model/Odontologo.php';

class OdontologoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Odontologo();
    }

    public function listarOdontologos() {
        return $this->modelo->listar();
    }

    public function obtenerOdontologo($id) {
        return $this->modelo->obtenerPorId($id);
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'eliminar') {
                $id = $_POST['id'] ?? 0;
                $this->modelo->eliminar($id);
                header("Location: odontologos.php?mensaje=eliminado");
                exit;
            }

            if ($accion === 'guardar' || $accion === 'actualizar') {
                $id = $_POST['id'] ?? null;
                $nombre = $_POST['nombre'] ?? '';
                $especialidad = $_POST['especialidad'] ?? '';
                $telefono = $_POST['telefono'] ?? '';
                $correo = $_POST['correo'] ?? '';

                if ($accion === 'actualizar' && $id) {
                    $this->modelo->actualizar($id, $nombre, $especialidad, $telefono, $correo);
                    header("Location: odontologos.php?mensaje=actualizado");
                } else {
                    $this->modelo->guardar($nombre, $especialidad, $telefono, $correo);
                    header("Location: odontologos.php?mensaje=guardado");
                }
                exit;
            }
        }
    }
}
?>