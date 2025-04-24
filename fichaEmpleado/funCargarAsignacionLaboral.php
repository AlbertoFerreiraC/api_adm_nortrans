<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idEmpleado' => $_POST['idEmpleado'],
        'division' => $_POST['division'],
        'empresa' => $_POST['empresa'],
        'centroDeCosto' => $_POST['centroDeCosto']
    );
    $api -> cargaAsignacionlaboralApi($item);
?>