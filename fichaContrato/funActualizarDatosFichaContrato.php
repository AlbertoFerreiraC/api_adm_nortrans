<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'idFicha' => $_POST['idFicha'],
    'empresa' => $_POST['empresa'],
    'fechaInicio' => $_POST['fechaInicio'],
    'sueldo' => $_POST['sueldo']
);
$api->actualizarDatosFichaContratoApi($item);
