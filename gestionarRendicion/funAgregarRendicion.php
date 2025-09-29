<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
        $datosRecibidos = file_get_contents("php://input");
            $datos = json_decode($datosRecibidos);
            $item = array(
                'usuario' => $datos->usuario, 
                'cargo' => $datos->cargo,
                'saldo_inicial' => $datos->saldo_inicial,
                'monto_rendido' => $datos->monto_rendido,
                'saldo' => $datos->saldo,
                'comentario_adicional' => $datos->comentario_adicional,
                'tabla' => $datos->tabla
            );
            $api -> agregarApi($item);  
    
?>