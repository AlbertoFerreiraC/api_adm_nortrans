<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idSolicitud' => $datos->idSolicitud,
        'bodega' => $datos->bodega,
        'empresa' => $datos->empresa,
        'tipoSolicitud' => $datos->tipoSolicitud,
        'maquina' => $datos->maquina,
        'preAprueba' => $datos->preAprueba,
        'observacion' => $datos->observacion
    );
    $api -> actualizarSolicitud($item);
?>