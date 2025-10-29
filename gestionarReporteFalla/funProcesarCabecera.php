<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idUsuario' => $datos->idUsuario,
        'maquina' => $datos->maquina,
        'kmActual' => $datos->kmActual,
        'conductor' => $datos->conductor
    );
    $api -> procesarCabeceraApi($item);
?>