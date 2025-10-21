<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'id' => $datos->id,
    'rut' => $datos->rut,
    'nombre' => $datos->nombre,
    'telefono' => $datos->telefono,
    'correo' => $datos->correo
);
$api->modificarApi($item);
