<?php
require_once __DIR__ . '/../controller/LoginController.php';

$loginController = new LoginController();
$error = $loginController->procesarLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica Odontológica</title>
    <!-- Enlazamos el CSS del profe (ajusta la ruta si es necesario) -->
    <link rel="stylesheet" href="../assetes/css/style.css">
    <style>
        /* Un pequeño estilo por si el del profe no carga bien */
        body { font-family: Arial; background: #e6f2ff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .caja { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="caja">
        <h2>Clínica "Sonrisa Perfecta"</h2>
        <p>Inicio de Sesión</p>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>