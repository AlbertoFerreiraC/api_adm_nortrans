<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'idcontratacion' => $datos->idcontratacion
);
$api->cambiarEstadoContratoApi($item);
?>