<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'patente' => $datos->patente,
    'numero_interno_maquina' => $datos->numero_interno_maquina,
    'anho_maquina' => $datos->anho_maquina,
    'capacidad_estanque' => $datos->capacidad_estanque,
    'secuencia_mantenimiento' => $datos->secuencia_mantenimiento,
    'numero_asientos' => $datos->numero_asientos,
    'numero_puertas' => $datos->numero_puertas,
    'centro_de_costo' => $datos->centro_de_costo,
    'padron' => $datos->padron
);
$api->agregarApi($item);
