<?php
session_start();
require_once __DIR__ . '/../controller/LoginController.php';

$loginController = new LoginController();
$error = $loginController->procesarLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica "Sonrisa Perfecta"</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assetes/css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        
        <div class="login-bienvenida">
            <div class="bienvenida-texto">
                <h1>Clínica <br>"Sonrisa Perfecta"</h1>
                <p>Gestión integral de pacientes, citas y tratamientos. Tu sonrisa está en las mejores manos.</p>
                <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?q=80&w=800&auto=format&fit=crop" alt="Dentista">
            </div>
        </div>

        <div class="login-formulario">
            <div class="caja-login">
                <div class="icono-login">
                    <i class="fa-solid fa-tooth"></i>
                </div>
                <h2>Bienvenido</h2>
                <p class="subtitulo">Ingresa tus credenciales para acceder</p>
                
                <?php if ($error): ?>
                    <div class="error-msg">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="input-group">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="correo" placeholder="Correo electrónico" required>
                    </div>
                    
                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="clave" placeholder="Contraseña" required>
                    </div>

                    <button type="submit">
                        Iniciar Sesión <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
                
                <p class="pie-formulario">
                    Sistema de Gestión Odontológica &copy; <?php echo date('Y'); ?>
                </p>
            </div>
        </div>

    </div>
</body>
</html>