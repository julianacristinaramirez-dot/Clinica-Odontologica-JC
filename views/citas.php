<?php
// views/citas.php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/CitaController.php';

$controller = new CitaController();
$controller->procesarFormulario();

$citas = $controller->listarCitas();
$pacientes = $controller->listarPacientes();
$odontologos = $controller->listarOdontologos();

$citaEditar = null;
if (isset($_GET['editar'])) {
    $citaEditar = $controller->obtenerCita($_GET['editar']);
}

require __DIR__ . '/layout.php';
layoutStart('Citas Médicas');
?>

<h2 class="titulo-panel">Gestión de Citas</h2>
<p class="subtitulo-panel">Programa, actualiza o cancela las citas de la clínica.</p>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="notice">
        <?php 
            if ($_GET['mensaje'] == 'guardado') echo "✅ Cita programada con éxito.";
            if ($_GET['mensaje'] == 'actualizado') echo "✅ Cita actualizada correctamente.";
            if ($_GET['mensaje'] == 'eliminado') echo "🗑️ Cita eliminada del sistema.";
        ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="panel">
    <h3><?= $citaEditar ? 'Editar Cita' : 'Programar Nueva Cita' ?></h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="<?= $citaEditar ? 'actualizar' : 'guardar' ?>">
        <input type="hidden" name="id" value="<?= $citaEditar['id'] ?? '' ?>">

        <div class="form-grid">
            <div>
                <label>Paciente:</label>
                <select name="id_paciente" required>
                    <option value="">Seleccione un paciente...</option>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($citaEditar && $citaEditar['id_paciente'] == $p['id']) ? 'selected' : '' ?>>
                            <?= $p['nombre'] ?> (DNI: <?= $p['dni'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Odontólogo:</label>
                <select name="id_odontologo" required>
                    <option value="">Seleccione un odontólogo...</option>
                    <?php foreach ($odontologos as $o): ?>
                        <option value="<?= $o['id'] ?>" <?= ($citaEditar && $citaEditar['id_odontologo'] == $o['id']) ? 'selected' : '' ?>>
                            <?= $o['nombre'] ?> - <?= $o['especialidad'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Fecha:</label>
                <input type="date" name="fecha" required value="<?= $citaEditar['fecha'] ?? '' ?>">
            </div>
            <div>
                <label>Hora:</label>
                <input type="time" name="hora" required value="<?= $citaEditar['hora'] ?? '' ?>">
            </div>
            <div>
                <label>Estado:</label>
                <select name="estado" required>
                    <option value="Pendiente" <?= ($citaEditar && $citaEditar['estado'] == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Atendida" <?= ($citaEditar && $citaEditar['estado'] == 'Atendida') ? 'selected' : '' ?>>Atendida</option>
                    <option value="Cancelada" <?= ($citaEditar && $citaEditar['estado'] == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <button type="submit"><?= $citaEditar ? 'Actualizar' : 'Guardar' ?></button>
            <?php if ($citaEditar): ?>
                <a href="citas.php" class="btn secondary">Cancelar Edición</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA -->
<div class="panel table-scroll">
    <h3>Listado de Citas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Odontólogo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td style="font-weight: 500;"><?= $c['paciente_nombre'] ?></td>
                    <td><?= $c['odontologo_nombre'] ?></td>
                    <td><?= $c['fecha'] ?></td>
                    <td><?= $c['hora'] ?></td>
                    <td>
                        <?php 
                            $claseBadge = 'badge-pendiente';
                            if ($c['estado'] == 'Atendida') $claseBadge = 'badge-atendida';
                            if ($c['estado'] == 'Cancelada') $claseBadge = 'badge-cancelada';
                        ?>
                        <span class="badge <?= $claseBadge ?>"><?= $c['estado'] ?></span>
                    </td>
                    <td>
                        <div class="acciones-celda">
                            <!-- Botón Editar con la clase base btn-tabla -->
                            <a href="citas.php?editar=<?= $c['id'] ?>" class="btn-tabla btn-editar">Editar</a>
                            
                            <!-- Botón Eliminar con la clase base btn-tabla -->
                            <form method="POST" action="" onsubmit="return confirm('¿Seguro que deseas eliminar esta cita?');">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button type="submit" class="btn-tabla btn-eliminar">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($citas)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding: 30px;">No hay citas programadas aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php layoutEnd(); ?>