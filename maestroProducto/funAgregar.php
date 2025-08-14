<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'categoria' => $datos->categoria,
    'sub_categoria' => $datos->sub_categoria,
    'unidad_de_medida' => $datos->unidad_de_medida,
    'descripcion' => $datos->descripcion,
    'stock_minimo' => $datos->stock_minimo,
    'tipo_producto' => $datos->tipo_producto,
    'unidad_medida' => $datos->unidad_medida
);
$api->agregarApi($item);
