<?php
include_once 'controlador.php';
$api = new ApiControlador();

$item = array(
    'cargo' => $_POST['cargo'],
    'empresa' => $_POST['empresa'],
    'centro_de_costo' => $_POST['centroDeCosto'],
    'turnos_laborales' => $_POST['turnosLaborales'],
    'tipo_bus' => $_POST['tipoBus'],
    'pre_aprueba' => $_POST['preAprueba'],
    'aprueba' => $_POST['aprueba'],
    'division' => $_POST['division'], 
    'cantidad_solicitada' => $_POST['cantidadSolicitada'],
    'licencia_de_conducir' => $_POST['licenciaDeConducir'],   
    'fecha_requerida' => $_POST['fechaRequerida'],
    'fecha_termino' => $_POST['fechaTermino'],
    'remuneracion' => $_POST['remuneracion'], 
    'motivo' => $_POST['motivo'] ?? '',   
    'tipo_contrato' => $_POST['tipo_contrato'],
    'observacionEntrevistaPsicolaboral' => $_POST['observacionEntrevistaPsicolaboral'],
    'observacionEntrevistaTecnica' => $_POST['observacionEntrevistaTecnica'],
    'observacionPruebaConduccion' => $_POST['observacionPruebaConduccion'],
    'comentarioGeneral' => $_POST['comentarioGeneral']
);
//var_dump($_POST);
$api->agregarApi($item);
