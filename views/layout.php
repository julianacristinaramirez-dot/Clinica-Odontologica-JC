<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('e')) {
    function e($texto) {
        return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('layoutStart')) {
    function layoutStart($titulo = 'Clínica Odontológica') {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= e($titulo) ?> - 🦷Sonrisa Perfecta🦷</title>
            <link rel="stylesheet" href="../assetes/css/style.css">
            <link rel="stylesheet" href="../assetes/css/tablas.css">  
        </head>
        <body>
            <header class="topbar">
                <div class="topbar-nivel1">
                    <h1>🦷 Clínica "Sonrisa Perfecta"</h1>
                    <div class="user-info">
                        <span>Bienvenido, <strong><?= e($_SESSION['nombre_usuario'] ?? 'Admin') ?></strong></span>
                        <a href="../controller/LogoutController.php" class="btn-salir">Cerrar Sesión</a>
                    </div>
                </div>
                <div class="topbar-nivel2">
                    <nav class="nav-horizontal">
                        <a href="home.php">Inicio</a>
                        <a href="pacientes.php">Pacientes</a>
                        <a href="citas.php">Citas</a>
                        <a href="odontologos.php">Odontólogos</a>
                        <a href="pagos.php">Pagos</a>
                    </nav>
                </div>
            </header>

            <div class="main-container">
                <aside class="sidebar-derecha">
                    <h3>Accesos Rápidos</h3>
                    <ul>
                        <li><a href="reportes.php">📊 Reportes</a></li>
                        <li><a href="tratamientos.php">🩺 Tratamientos</a></li>
                        <li><a href="servicios.php">💰 Servicios</a></li>
                    </ul>
                </aside>

                <main class="contenido-principal">
        <?php
    }
}

if (!function_exists('layoutEnd')) {
    function layoutEnd() {
        ?>
                </main>
            </div>

            <footer class="footer">
                <p>&copy; <?= date('Y') ?> Clínica Odontológica JC "Sonrisa Perfecta". Todos los derechos reservados JC.</p>
            </footer>
        </body>
        </html>
        <?php
    }
}
?>