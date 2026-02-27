<?php
    include_once 'apiRoles.php';
    $api = new ApiRoles();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'id' => $datos->id,
    );
    $api -> eliminarApi($item);
?>