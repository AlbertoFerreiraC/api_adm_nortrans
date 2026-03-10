<?php

include_once 'controlador.php';

$api = new ApiControlador();

// Si no necesitas parámetros puedes dejar vacío
$datosRecibidos = file_get_contents("php://input");

$datos = json_decode($datosRecibidos, true);

$api->listarConsultaSMS();
