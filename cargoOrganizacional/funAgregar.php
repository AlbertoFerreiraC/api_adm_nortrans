<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'area_negocio' => $datos->area_negocio,
        'area_dependencia' =>  $datos->area_dependencia,
        'nombre' =>$datos->nombre,
        'division' =>  $datos->division,
        'solicitud_personal' =>  $datos->solicitud_personal,
        'autoriza_ms' =>  $datos->autoriza_ms, 
        'autoriza_oc' =>$datos->autoriza_oc,
        'aprueba_solicitud' =>  $datos->aprueba_solicitud
    );


$api->agregarApi($item);
