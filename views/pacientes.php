<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/PacienteController.php';

$controller = new PacienteController();
$controller->procesarFormulario(); 

$pacientes = $controller->listarPacientes();
$pacienteEditar = null;

if (isset($_GET['editar'])) {
    $pacienteEditar = $controller->obtenerPaciente($_GET['editar']);
}

require __DIR__ . '/layout.php';
layoutStart('Pacientes');
?>

<h2 class="titulo-panel">Gestión de Pacientes</h2>
<p class="subtitulo-panel">Registra, edita o elimina los datos de los pacientes de la clínica.</p>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="notice">
        <?php 
            if ($_GET['mensaje'] == 'guardado') echo "✅ Paciente registrado con éxito.";
            if ($_GET['mensaje'] == 'actualizado') echo "✅ Paciente actualizado correctamente.";
            if ($_GET['mensaje'] == 'eliminado') echo "🗑️ Paciente eliminado del sistema.";
        ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="panel">
    <h3><?= $pacienteEditar ? 'Editar Paciente' : 'Nuevo Paciente' ?></h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="<?= $pacienteEditar ? 'actualizar' : 'guardar' ?>">
        <input type="hidden" name="id" value="<?= $pacienteEditar['id'] ?? '' ?>">

        <div class="form-grid">
            <div>
                <label>Nombre completo:</label>
                <input type="text" name="nombre" required value="<?= $pacienteEditar['nombre'] ?? '' ?>">
            </div>
            <div>
                <label>DNI:</label>
                <input type="text" name="dni" required value="<?= $pacienteEditar['dni'] ?? '' ?>">
            </div>
            <div>
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?= $pacienteEditar['telefono'] ?? '' ?>">
            </div>
            <div>
                <label>Correo:</label>
                <input type="email" name="correo" value="<?= $pacienteEditar['correo'] ?? '' ?>">
            </div>
            <div>
                <label>Dirección:</label>
                <input type="text" name="direccion" value="<?= $pacienteEditar['direccion'] ?? '' ?>">
            </div>
            <div>
                <label>Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" value="<?= $pacienteEditar['fecha_nacimiento'] ?? '' ?>">
            </div>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <button type="submit"><?= $pacienteEditar ? 'Actualizar' : 'Guardar' ?></button>
            <?php if ($pacienteEditar): ?>
                <a href="pacientes.php" class="btn secondary">Cancelar Edición</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA -->
<div class="panel table-scroll">
    <h3>Listado de Pacientes</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['nombre'] ?></td>
                    <td><?= $p['dni'] ?></td>
                    <td><?= $p['telefono'] ?></td>
                    <td><?= $p['correo'] ?></td>
                    <td class="actions">
                        <a href="pacientes.php?editar=<?= $p['id'] ?>" class="btn" style="background:#f0ad4e;">Editar</a>
                        <form method="POST" action="" onsubmit="return confirm('¿Seguro que deseas eliminar este paciente?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pacientes)): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No hay pacientes registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php layoutEnd(); ?>