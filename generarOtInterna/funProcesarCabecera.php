<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idUsuario' => $datos->idUsuario,
        'fecha' => $datos->fecha,
        'kmActual' => $datos->kmActual,
        'maquina' => $datos->maquina,
        'centroCosto' => $datos->centroCosto,
    );
    $api -> procesarCabeceraApi($item);
?>