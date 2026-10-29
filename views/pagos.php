<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/PagoController.php';

$controller = new PagoController();
$controller->procesarFormulario();

$pagos = $controller->listarPagos();
$citas = $controller->listarCitas(); 

$pagoEditar = null;
if (isset($_GET['editar'])) {
    $pagoEditar = $controller->obtenerPago($_GET['editar']);
}

require __DIR__ . '/layout.php';
layoutStart('Pagos');
?>

<h2 class="titulo-panel">Gestión de Pagos</h2>
<p class="subtitulo-panel">Registra los ingresos de la clínica por citas atendidas.</p>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="notice">
        <?php 
            if ($_GET['mensaje'] == 'guardado') echo "✅ Pago registrado con éxito.";
            if ($_GET['mensaje'] == 'actualizado') echo "✅ Pago actualizado correctamente.";
            if ($_GET['mensaje'] == 'eliminado') echo "🗑️ Pago eliminado del sistema.";
        ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="panel">
    <h3><?= $pagoEditar ? 'Editar Pago' : 'Registrar Nuevo Pago' ?></h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="<?= $pagoEditar ? 'actualizar' : 'guardar' ?>">
        <input type="hidden" name="id" value="<?= $pagoEditar['id'] ?? '' ?>">

        <div class="form-grid">
            <div>
                <label>Cita (Paciente y Fecha):</label>
                <select name="id_cita" required>
                    <option value="">Seleccione una cita...</option>
                    <?php foreach ($citas as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($pagoEditar && $pagoEditar['id_cita'] == $c['id']) ? 'selected' : '' ?>>
                            <?= $c['paciente_nombre'] ?> - <?= $c['fecha'] ?> (<?= $c['hora'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Monto (S/):</label>
                <input type="number" step="0.01" name="monto" required placeholder="Ej. 150.00" value="<?= $pagoEditar['monto'] ?? '' ?>">
            </div>
            <div>
                <label>Método de Pago:</label>
                <select name="metodo_pago" required>
                    <option value="">Seleccione método...</option>
                    <option value="Efectivo" <?= ($pagoEditar && $pagoEditar['metodo_pago'] == 'Efectivo') ? 'selected' : '' ?>>Efectivo</option>
                    <option value="Tarjeta de Crédito" <?= ($pagoEditar && $pagoEditar['metodo_pago'] == 'Tarjeta de Crédito') ? 'selected' : '' ?>>Tarjeta de Crédito</option>
                    <option value="Tarjeta de Débito" <?= ($pagoEditar && $pagoEditar['metodo_pago'] == 'Tarjeta de Débito') ? 'selected' : '' ?>>Tarjeta de Débito</option>
                    <option value="Yape" <?= ($pagoEditar && $pagoEditar['metodo_pago'] == 'Yape') ? 'selected' : '' ?>>Yape</option>
                </select>
            </div>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <button type="submit"><?= $pagoEditar ? 'Actualizar' : 'Guardar' ?></button>
            <?php if ($pagoEditar): ?>
                <a href="pagos.php" class="btn secondary">Cancelar Edición</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA -->
<div class="panel table-scroll">
    <h3>Historial de Pagos</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Fecha Cita</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Fecha de Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['paciente_nombre'] ?></td>
                    <td><?= $p['cita_fecha'] ?></td>
                    <td><strong>S/ <?= number_format($p['monto'], 2) ?></strong></td>
                    <td><?= $p['metodo_pago'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($p['fecha_pago'])) ?></td>
                    <td class="actions">
                        <a href="pagos.php?editar=<?= $p['id'] ?>" class="btn" style="background:#f0ad4e;">Editar</a>
                        <form method="POST" action="" onsubmit="return confirm('¿Seguro que deseas eliminar este pago?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pagos)): ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No hay pagos registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php layoutEnd(); ?>