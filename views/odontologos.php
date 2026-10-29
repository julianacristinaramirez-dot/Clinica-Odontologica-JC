<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/OdontologoController.php';

$controller = new OdontologoController();
$controller->procesarFormulario();

$odontologos = $controller->listarOdontologos();
$odontologoEditar = null;

if (isset($_GET['editar'])) {
    $odontologoEditar = $controller->obtenerOdontologo($_GET['editar']);
}

require __DIR__ . '/layout.php';
layoutStart('Odontólogos');
?>

<h2 class="titulo-panel">Gestión de Odontólogos</h2>
<p class="subtitulo-panel">Administra el personal médico y sus especialidades.</p>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="notice">
        <?php 
            if ($_GET['mensaje'] == 'guardado') echo "✅ Odontólogo registrado con éxito.";
            if ($_GET['mensaje'] == 'actualizado') echo "✅ Datos actualizados correctamente.";
            if ($_GET['mensaje'] == 'eliminado') echo "🗑️ Odontólogo eliminado del sistema.";
        ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="panel">
    <h3><?= $odontologoEditar ? 'Editar Odontólogo' : 'Nuevo Odontólogo' ?></h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="<?= $odontologoEditar ? 'actualizar' : 'guardar' ?>">
        <input type="hidden" name="id" value="<?= $odontologoEditar['id'] ?? '' ?>">

        <div class="form-grid">
            <div>
                <label>Nombre completo:</label>
                <input type="text" name="nombre" required value="<?= $odontologoEditar['nombre'] ?? '' ?>">
            </div>
            <div>
                <label>Especialidad:</label>
                <input type="text" name="especialidad" required placeholder="Ej. Ortodoncia, Endodoncia..." value="<?= $odontologoEditar['especialidad'] ?? '' ?>">
            </div>
            <div>
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?= $odontologoEditar['telefono'] ?? '' ?>">
            </div>
            <div>
                <label>Correo:</label>
                <input type="email" name="correo" value="<?= $odontologoEditar['correo'] ?? '' ?>">
            </div>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <button type="submit"><?= $odontologoEditar ? 'Actualizar' : 'Guardar' ?></button>
            <?php if ($odontologoEditar): ?>
                <a href="odontologos.php" class="btn secondary">Cancelar Edición</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA -->
<div class="panel table-scroll">
    <h3>Listado de Odontólogos</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($odontologos as $o): ?>
                <tr>
                    <td><?= $o['id'] ?></td>
                    <td><?= $o['nombre'] ?></td>
                    <td><?= $o['especialidad'] ?></td>
                    <td><?= $o['telefono'] ?></td>
                    <td><?= $o['correo'] ?></td>
                    <td class="actions">
                        <a href="odontologos.php?editar=<?= $o['id'] ?>" class="btn" style="background:#f0ad4e;">Editar</a>
                        <form method="POST" action="" onsubmit="return confirm('¿Seguro que deseas eliminar este odontólogo?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $o['id'] ?>">
                            <button type="submit" class="btn danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($odontologos)): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No hay odontólogos registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php layoutEnd(); ?>