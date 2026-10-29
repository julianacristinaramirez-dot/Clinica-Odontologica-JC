<?php

function exigirSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['id_usuario'])) {
        header("Location: ../views/login.php");
        exit;
    }
}

function modulos() {
    return [
        'pacientes' => ['nombre' => 'Pacientes', 'url' => 'pacientes.php'],
        'citas' => ['nombre' => 'Citas Médicas', 'url' => 'citas.php'],
        'odontologos' => ['nombre' => 'Odontólogos', 'url' => 'odontologos.php'],
        'tratamientos' => ['nombre' => 'Tratamientos', 'url' => 'tratamientos.php'],
        'servicios' => ['nombre' => 'Servicios', 'url' => 'servicios.php'],
        'pagos' => ['nombre' => 'Pagos', 'url' => 'pagos.php'],
        'reportes' => ['nombre' => 'Reportes', 'url' => 'reportes.php'],
    ];
}
?>