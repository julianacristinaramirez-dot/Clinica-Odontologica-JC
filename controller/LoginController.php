<?php
require_once __DIR__ . '/../model/Usuario.php';

class LoginController {
    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = trim($_POST['correo'] ?? '');
            $clave = trim($_POST['clave'] ?? '');

            if (empty($correo) || empty($clave)) {
                return "Por favor, complete todos los campos.";
            }

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($correo, $clave);

            if ($usuario) {
                // Iniciar sesión y guardar datos
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir a la página principal
                header("Location: ../views/home.php");
                exit;
            } else {
                return "Correo o contraseña incorrectos.";
            }
        }
        return null;
    }
}
?>