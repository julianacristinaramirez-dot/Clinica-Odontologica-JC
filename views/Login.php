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
    <link rel="stylesheet" href="../assetes/css/style.css">
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