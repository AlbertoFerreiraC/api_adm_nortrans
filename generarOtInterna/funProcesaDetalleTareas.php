<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idOt' => $datos->idOt,
        'tabla' => $datos->tabla
    );
    $api -> procesarDetalleTareaApi($item);
?>