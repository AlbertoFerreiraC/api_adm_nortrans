<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idOt' => $datos->idOt,
        'fecha' => $datos->fecha,
        'kmActual' => $datos->kmActual,
        'maquina' => $datos->maquina,
        'centroCosto' => $datos->centroCosto
    );
    $api -> modificarCabeceraApi($item);
?>