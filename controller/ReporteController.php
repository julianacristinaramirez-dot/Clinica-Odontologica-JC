<?php
require_once __DIR__ . '/../model/Reporte.php';

class ReporteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Reporte();
    }

    public function obtenerDatosReportes() {
        return [
            'ingresos_totales' => $this->modelo->totalIngresos(),
            'citas_pendientes' => $this->modelo->totalCitasPendientes(),
            'atenciones' => $this->modelo->atencionesRealizadas(),
            'metodos_pago' => $this->modelo->ingresosPorMetodo()
        ];
    }
}
?>