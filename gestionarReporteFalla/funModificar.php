<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'id' => $datos->idFalla,
        'maquina' => $datos->maquina,
        'kmActual' => $datos->kmActual,
        'conductor' => $datos->conductor
    );
    $api -> modificarApi($item);
?>