<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'usuario' => $datos->usuario ?? '-',
    'cargo' => $datos->cargo ?? '-',
    'empresa' => $datos->empresa ?? '-',
    'centro_de_costo' => $datos->centroDeCosto ?? '-',
    'turnos_laborales' => $datos->turnosLaborales ?? '-',
    'tipo_bus' => (isset($datos->tipoBus) && is_numeric($datos->tipoBus)) ? (int)$datos->tipoBus : null,
    'pre_aprueba' => $datos->preAprueba ?? '-',
    'aprueba' => $datos->aprueba ?? '-',
    'division' => $datos->division ?? '-',
    'cantidad_solicitada' => (isset($datos->cantidadSolicitada) && is_numeric($datos->cantidadSolicitada)) ? (int)$datos->cantidadSolicitada : 0,
    'licencia_de_conducir' => (isset($datos->licenciaDeConducir) && $datos->licenciaDeConducir !== '' && $datos->licenciaDeConducir !== 'Seleccionar...')
        ? $datos->licenciaDeConducir
        : null,
    'fecha_requerida' => $datos->fechaRequerida ?? '-',
    'fecha_termino' => $datos->fechaTermino ?? '-',
    'remuneracion' => (isset($datos->remuneracion) && is_numeric($datos->remuneracion)) ? (float)$datos->remuneracion : 0,
    'comentario_general' => $datos->comentario_general ?? '-',
    'motivo' => $datos->motivo ?? '-',
    'tipo_contrato' => $datos->tipo_contrato ?? '-',
    'tabla' => $datos->tabla ?? '-',
    'comentario_general' => $datos->comentario_general ?? '-'
);


$api->agregarApi($item);
