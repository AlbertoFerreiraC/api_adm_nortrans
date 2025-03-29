<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'usuario' => $datos->usuario,
    'cargo' => $datos->cargo,
    'empresa' => $datos->empresa,
    'centro_de_costo' => $datos->centroDeCosto,
    'turnos_laborales' => $datos->turnosLaborales,
    'tipo_bus' => $datos->tipoBus,
    'pre_aprueba' => $datos->preAprueba,
    'aprueba' => $datos->aprueba,
    'division' => $datos->division,
    'cantidad_solicitada' => $datos->cantidadSolicitada,
    'licencia_de_conducir' => $datos->licenciaDeConducir,
    'fecha_requerida' => $datos->fechaRequerida,
    'fecha_termino' => $datos->fechaTermino,
    'remuneracion' => $datos->remuneracion,
    'comentario_general' => $datos->comentario_general,
    'motivo' => $datos->motivo,
    'tipo_contrato' => $datos->tipo_contrato,
    'tabla' => $datos->tabla
);
$api->agregarApi($item);
