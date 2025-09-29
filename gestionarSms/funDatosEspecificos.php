<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'tipo' => $datos->tipo,
        'valor' => $datos->valor
    );
    $api -> obtenerDatosEspecificosApi($item);
?>