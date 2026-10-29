<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require_once __DIR__ . '/../controller/ReporteController.php';

$controller = new ReporteController();
$datos = $controller->obtenerDatosReportes();

require __DIR__ . '/layout.php';
layoutStart('Reportes');
?>

<h2 class="titulo-panel">Reportes y Estadísticas</h2>
<p class="subtitulo-panel">Resumen de la gestión de la clínica odontológica.</p>

<!-- TARJETAS DE RESUMEN -->
<div class="cards-resumen" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <!-- Ingresos -->
    <div class="panel" style="background: linear-gradient(135deg, var(--secundario), #8cd6b4); color: #155724; text-align: center;">
        <h3 style="color: #155724; border-bottom: none;">Ingresos Totales</h3>
        <h2 style="font-size: 36px; margin: 10px 0;">S/ <?= number_format($datos['ingresos_totales'], 2) ?></h2>
        <p>Dinero recaudado</p>
    </div>

    <!-- Citas Pendientes -->
    <div class="panel" style="background: linear-gradient(135deg, #ffd6ba, #ffc49e); color: #856404; text-align: center;">
        <h3 style="color: #856404; border-bottom: none;">Citas Pendientes</h3>
        <h2 style="font-size: 36px; margin: 10px 0;"><?= $datos['citas_pendientes'] ?></h2>
        <p>Citas por atender</p>
    </div>

    <!-- Atenciones Realizadas -->
    <div class="panel" style="background: linear-gradient(135deg, var(--primario), var(--primario-oscuro)); color: white; text-align: center;">
        <h3 style="color: white; border-bottom: none;">Atenciones Realizadas</h3>
        <h2 style="font-size: 36px; margin: 10px 0;"><?= count($datos['atenciones']) ?></h2>
        <p>Pacientes atendidos</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- Gráfico de Ingresos por Método -->
    <div class="panel">
        <h3>Ingresos por Método de Pago</h3>
        <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
            <?php foreach ($datos['metodos_pago'] as $m): ?>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;"><?= $m['metodo_pago'] ?></span>
                        <span>S/ <?= number_format($m['total'], 2) ?></span>
                    </div>
                    <!-- Barra de progreso visual -->
                    <div style="width: 100%; background: var(--fondo-2); height: 15px; border-radius: 10px; overflow: hidden;">
                        <?php 
                            // Calculamos el porcentaje para que la barra se llene
                            $porcentaje = ($m['total'] / ($datos['ingresos_totales'] ?: 1)) * 100; 
                        ?>
                        <div style="width: <?= $porcentaje ?>%; background: var(--primario); height: 100%; border-radius: 10px;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tabla de Atenciones Realizadas -->
    <div class="panel table-scroll">
        <h3>Atenciones Realizadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Paciente</th>
                    <th>Odontólogo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['atenciones'] as $a): ?>
                    <tr>
                        <td><?= $a['fecha'] ?></td>
                        <td><?= $a['paciente'] ?></td>
                        <td><?= $a['odontologo'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($datos['atenciones'])): ?>
                    <tr>
                        <td colspan="3" style="text-align:center;">No hay atenciones realizadas aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php layoutEnd(); ?>