<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'usuario' => $datos->usuario,
        'bodega' => $datos->bodega,
        'empresa' => $datos->empresa,
        'tipoSolicitud' => $datos->tipoSolicitud,
        'maquina' => $datos->maquina,
        'preAprueba' => $datos->preAprueba,
        'observacion' => $datos->observacion,
        'tabla' => $datos->tabla
    );
    $api -> generarSolicitudApi($item);
?>