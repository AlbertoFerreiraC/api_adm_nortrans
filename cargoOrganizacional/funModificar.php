<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'idcargo_organizacional' => $_POST['idcargo_organizacional'],
    'area_negocio' => $_POST['area_negocio'],
    'area_dependencia' => $_POST['area_dependencia'],
    'nombre' => $_POST['nombre'],
    'division' => $_POST['division'],
    'solicitud_personal' => $_POST['solicitud_personal'],
    'autoriza_ms' => $_POST['autoriza_ms'],
    'aprueba_solicitud' => $_POST['aprueba_solicitud'],
);
$api->modificarApi($item);
