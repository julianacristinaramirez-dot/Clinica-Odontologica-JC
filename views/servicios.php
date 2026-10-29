<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/ServicioController.php';

$controller = new ServicioController();
$controller->procesarFormulario();

$servicios = $controller->listarServicios();
$servicioEditar = null;

if (isset($_GET['editar'])) {
    $servicioEditar = $controller->obtenerServicio($_GET['editar']);
}

require __DIR__ . '/layout.php';
layoutStart('Servicios');
?>

<h2 class="titulo-panel">Gestión de Servicios</h2>
<p class="subtitulo-panel">Administra los tratamientos y precios que ofrece la clínica.</p>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="notice">
        <?php 
            if ($_GET['mensaje'] == 'guardado') echo "✅ Servicio registrado con éxito.";
            if ($_GET['mensaje'] == 'actualizado') echo "✅ Servicio actualizado correctamente.";
            if ($_GET['mensaje'] == 'eliminado') echo "🗑️ Servicio eliminado del sistema.";
        ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="panel">
    <h3><?= $servicioEditar ? 'Editar Servicio' : 'Nuevo Servicio' ?></h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="<?= $servicioEditar ? 'actualizar' : 'guardar' ?>">
        <input type="hidden" name="id" value="<?= $servicioEditar['id'] ?? '' ?>">

        <div class="form-grid">
            <div>
                <label>Nombre del Servicio:</label>
                <input type="text" name="nombre" required placeholder="Ej. Limpieza Dental" value="<?= $servicioEditar['nombre'] ?? '' ?>">
            </div>
            <div>
                <label>Precio (S/):</label>
                <input type="number" step="0.01" name="precio" required placeholder="Ej. 50.00" value="<?= $servicioEditar['precio'] ?? '' ?>">
            </div>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <button type="submit"><?= $servicioEditar ? 'Actualizar' : 'Guardar' ?></button>
            <?php if ($servicioEditar): ?>
                <a href="servicios.php" class="btn secondary">Cancelar Edición</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA -->
<div class="panel table-scroll">
    <h3>Listado de Servicios</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicios as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= $s['nombre'] ?></td>
                    <td><strong>S/ <?= number_format($s['precio'], 2) ?></strong></td>
                    <td class="actions">
                        <a href="servicios.php?editar=<?= $s['id'] ?>" class="btn btn-editar">Editar</a>
                        <form method="POST" action="" onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $s['id'] ?>">
                            <button type="submit" class="btn btn-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($servicios)): ?>
                <tr>
                    <td colspan="4" style="text-align:center;">No hay servicios registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php layoutEnd(); ?>