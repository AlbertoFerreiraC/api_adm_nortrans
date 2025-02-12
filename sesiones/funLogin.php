<?php

    include_once 'apiSesiones.php';
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8');
    $api = new ApiSesiones();
    $datosRecibidos = file_get_contents("php://input");
    $usuario = json_decode($datosRecibidos);
    $item = array(
        'nic' => $usuario->nic,
        'pass' => $usuario->pass
    );
    $api -> login($item);
?>