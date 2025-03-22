<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'idficha_contrato' => $_POST['idficha_contrato'],
    'contratacion' => $_POST['contratacion'],
    'empresa' => $_POST['empresa'],
    'division' => $_POST['division'],
    'cargo' => $_POST['cargo'],
    'tipo_contrato' => $_POST['tipo_contrato'],
    'fecha_inicio' => $_POST['fecha_inicio'],
    'turnos_laborales' => $_POST['turnos_laborales'],
    'fecha_inicio' => $_POST['fecha_inicio'],
    'sueldo_liquido' => $_POST['sueldo_liquido'],
);
$api->modificarApi($item);
