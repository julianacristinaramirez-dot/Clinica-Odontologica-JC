<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/TratamientoController.php';

$controller = new TratamientoController();
$controller->procesarFormulario();

$tratamientos = $controller->listarTratamientos();
$citas = $controller->listarCitas();
$servicios = $controller->listarServicios();

$tratamientoEditar = null;
if (isset($_GET['editar'])) {
    $tratamientoEditar = $controller->obtenerTratamiento($_GET['editar']);
}

require __DIR__ . '/layout.php';
layoutStart('Tratamientos');
?>

<h2 class="titulo-panel">Gestión de Tratamientos</h2>
<p class="subtitulo-panel">Registra los diagnósticos y procedimientos realizados a los pacientes.</p>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="notice">
        <?php 
            if ($_GET['mensaje'] == 'guardado') echo "✅ Tratamiento registrado con éxito.";
            if ($_GET['mensaje'] == 'actualizado') echo "✅ Tratamiento actualizado correctamente.";
            if ($_GET['mensaje'] == 'eliminado') echo "🗑️ Tratamiento eliminado del sistema.";
        ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="panel">
    <h3><?= $tratamientoEditar ? 'Editar Tratamiento' : 'Nuevo Tratamiento' ?></h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="<?= $tratamientoEditar ? 'actualizar' : 'guardar' ?>">
        <input type="hidden" name="id" value="<?= $tratamientoEditar['id'] ?? '' ?>">

        <div class="form-grid">
            <div>
                <label>Cita / Paciente:</label>
                <select name="id_cita" required>
                    <option value="">Seleccione una cita...</option>
                    <?php foreach ($citas as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($tratamientoEditar && $tratamientoEditar['id_cita'] == $c['id']) ? 'selected' : '' ?>>
                            <?= $c['paciente_nombre'] ?> - <?= $c['fecha'] ?> (<?= $c['hora'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Servicio Realizado:</label>
                <select name="id_servicio" required>
                    <option value="">Seleccione un servicio...</option>
                    <?php foreach ($servicios as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= ($tratamientoEditar && $tratamientoEditar['id_servicio'] == $s['id']) ? 'selected' : '' ?>>
                            <?= $s['nombre'] ?> (S/ <?= number_format($s['precio'], 2) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Diagnóstico:</label>
                <input type="text" name="diagnostico" required placeholder="Ej. Caries en molar inferior" value="<?= $tratamientoEditar['diagnostico'] ?? '' ?>">
            </div>
            <div>
                <label>Observaciones:</label>
                <input type="text" name="observaciones" placeholder="Detalles adicionales..." value="<?= $tratamientoEditar['observaciones'] ?? '' ?>">
            </div>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <button type="submit"><?= $tratamientoEditar ? 'Actualizar' : 'Guardar' ?></button>
            <?php if ($tratamientoEditar): ?>
                <a href="tratamientos.php" class="btn secondary">Cancelar Edición</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA -->
<div class="panel table-scroll">
    <h3>Listado de Tratamientos</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Servicio</th>
                <th>Diagnóstico</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tratamientos as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= $t['paciente_nombre'] ?></td>
                    <td><?= $t['servicio_nombre'] ?></td>
                    <td><?= $t['diagnostico'] ?></td>
                    <td><?= $t['observaciones'] ?></td>
                    <td class="actions">
                        <a href="tratamientos.php?editar=<?= $t['id'] ?>" class="btn" style="background:#f0ad4e;">Editar</a>
                        <form method="POST" action="" onsubmit="return confirm('¿Seguro que deseas eliminar este tratamiento?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <button type="submit" class="btn danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($tratamientos)): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No hay tratamientos registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php layoutEnd(); ?>