<?php
require_once __DIR__ . '/../controller/BaseController.php';
exigirSesion();
require __DIR__ . '/layout.php';

$imagenes = [
    'pacientes' => 'photo-1606811841689-23dfddce3e95',
    'citas' => 'photo-1506784983877-45594efa4cbe',
    'odontologos' => 'photo-1629909613654-28e377c37b09',
    'tratamientos' => 'photo-1588776814546-1ffcf47267a5',
    'servicios' => 'photo-1609840114035-3c981b782dfe',
    'pagos' => 'photo-1556742049-0cfed4f6a45d',
    'reportes' => 'photo-1551288049-bebda4e38f71',
];

layoutStart('Panel de Control');
?>
<h2 class="titulo-panel">Bienvenido al Sistema de Gestión</h2>
<p class="subtitulo-panel">Administra pacientes, citas, tratamientos y pagos de la clínica.</p>

<div class="cards">
    <?php foreach (modulos() as $id => $modulo): ?>
        <a class="card" href="<?= e($modulo['url']) ?>">
            <img
                loading="lazy"
                alt="<?= e($modulo['nombre']) ?>"
                src="https://images.unsplash.com/<?= e($imagenes[$id]) ?>?w=700&amp;q=75"
            >
            <div>
                <h2><?= e($modulo['nombre']) ?></h2>
                <span>Administrar registros →</span>
            </div>
        </a>
    <?php endforeach; ?>
</div>
<?php layoutEnd(); ?>