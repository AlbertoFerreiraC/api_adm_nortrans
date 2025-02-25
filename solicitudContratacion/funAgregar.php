<?php
include_once 'controlador.php';
$api = new ApiControlador();

$item = array(
    'cargo' => $_POST['cargo'],
    'empresa' => $_POST['empresa'],
    'division' => $_POST['division'], // No estaba división
    'centro_de_costo' => $_POST['centroDeCosto'],
    'turnos_laborales' => $_POST['turnosLaborales'],
    'tipo_bus' => $_POST['tipoBus'],
    'pre_aprueba' => $_POST['preAprueba'],
    'aprueba' => $_POST['aprueba'],
    'motivo' => $_POST['direcmotivocion'] ?? '',
    'cantidad_solicitada' => $_POST['cantidadSolicitada'],
    'licencia_de_conducir' => $_POST['licenciaDeConducir'],
    'tipo_documento' => $_POST['tipoDocumento'],
    'fecha_requerida' => $_POST['fechaRequerida'],
    'fecha_termino' => $_POST['fechaTermino'],
    'remuneracion' => $_POST['remuneracion'],
    'comentario_general' => $_POST['comentarioGeneral'],
    'tipoContrato' => $_POST['tipoContrato']
);
//var_dump($_POST);
$api->agregarApi($item);
