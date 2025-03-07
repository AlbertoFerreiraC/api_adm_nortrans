<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'idcontratacion' => $_POST['idcontratacion'],
    'cargo' => $_POST['cargo'],
    'empresa' => $_POST['empresa'],
    'division' => $_POST['division'],
    'centro_de_costo' => $_POST['centroDeCosto'],
    'turnos_laborales' => $_POST['turnosLaborales'],
    'tipo_bus' => $_POST['tipoBus'],
    'pre_aprueba' => $_POST['preAprueba'],
    'aprueba' => $_POST['aprueba'],
    'motivo' => $_POST['motivo'],
    'cantidad_solicitada' => $_POST['cantidadSolicitada'],
    'licencia_de_conducir' => $_POST['licenciaDeConducir'],
    'tipo_contrato' => $_POST['tipo_contrato'],
    'fecha_requerida' => $_POST['fechaRequerida'],
    'fecha_termino' => $_POST['fechaTermino'],
    'remuneracion' => $_POST['remuneracion'],
    'comentario_general' => $_POST['comentarioGeneral'],
    'entrevista_psicolaboral' => $_POST['observacionEntrevistaPsicolaboral'],
    'entrevista_tecnica' => $_POST['observacionEntrevistaTecnica'],
    'entrevista_conduccion' => $_POST['observacionPruebaConduccion'],
    'observacion_pre_aprobacion' => $_POST['observacion_pre_aprobacion'],
    'fecha_pre_aperobacion' => $_POST['fecha_pre_aperobacion'],
);
$api->modificarApi($item);
