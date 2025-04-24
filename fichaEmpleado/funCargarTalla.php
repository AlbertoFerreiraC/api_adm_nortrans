<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idEmpleado' => $_POST['idEmpleado'],
        'tipoEpp' => $_POST['tipoEpp'],
        'nroTalla' => $_POST['nroTalla']
    );
    $api -> cargarTallaApi($item);
?>