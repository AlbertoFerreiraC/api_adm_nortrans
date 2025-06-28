<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'comuna' => $datos->comuna,
    'condicion_de_pago' => $datos->condicion_de_pago,
    'tipo_de_proveedor' => $datos->tipo_de_proveedor,
    'descripcion' => $datos->descripcion,
    'rut' => $datos->rut,
    'telefono_contacto' => $datos->telefono_contacto,
    'correo_contacto' => $datos->correo_contacto,
    'direccion' => $datos->direccion,
    'criticidad' => $datos->criticidad
);
$api->agregarApi($item);
