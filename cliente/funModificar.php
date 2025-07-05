<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'id' => $datos->id,
    'rut' => $datos->rut,
    'nombre' => $datos->nombre,
    'apellido' => $datos->apellido,
    'telefono' => $datos->telefono,
    'correo' => $datos->correo,
    'direccion' => $datos->direccion
);
$api->modificarApi($item);
