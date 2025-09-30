<?php

include_once 'sql.php';

class ApiControlador{
   
    function listarApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listar();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idfondo_para_rendicion'],
                   'fecha_carga'=> $valor['fecha_carga'],
                   'realizado_por'=> $valor['realizado_por'],
                   'otorgado_a'=> $valor['otorgado_a'],
                   'monto'=> $valor['monto'],
                   'pre_aprueba'=> $valor['pre_aprueba'],
                   'aprueba'=> $valor['aprueba'],
                   'fecha_pre_aprobacion'=> $valor['fecha_pre_aprobacion'],
                   'fecha_aprobacion'=> $valor['fecha_aprobacion'],
                   'motivo'=> $valor['motivo'],
                   'observacion_pre_aprobacion'=> $valor['observacion_pre_aprobacion'],
                   'observacion_aprobacion'=> $valor['observacion_aprobacion'],
                   'motivo_baja'=> $valor['motivo_baja'],
                   'estado'=> $valor['estado']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarPreAprobacionesApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarPreAprobaciones($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idfondo_para_rendicion'],
                   'fecha_carga'=> $valor['fecha_carga'],
                   'realizado_por'=> $valor['realizado_por'],
                   'otorgado_a'=> $valor['otorgado_a'],
                   'monto'=> $valor['monto'],
                   'pre_aprueba'=> $valor['pre_aprueba'],
                   'aprueba'=> $valor['aprueba'],
                   'fecha_pre_aprobacion'=> $valor['fecha_pre_aprobacion'],
                   'fecha_aprobacion'=> $valor['fecha_aprobacion'],
                   'motivo'=> $valor['motivo'],
                   'observacion_pre_aprobacion'=> $valor['observacion_pre_aprobacion'],
                   'observacion_aprobacion'=> $valor['observacion_aprobacion'],
                   'motivo_baja'=> $valor['motivo_baja'],
                   'estado'=> $valor['estado']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarAprobacionesApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarAprobaciones($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idfondo_para_rendicion'],
                   'fecha_carga'=> $valor['fecha_carga'],
                   'realizado_por'=> $valor['realizado_por'],
                   'otorgado_a'=> $valor['otorgado_a'],
                   'monto'=> $valor['monto'],
                   'pre_aprueba'=> $valor['pre_aprueba'],
                   'aprueba'=> $valor['aprueba'],
                   'fecha_pre_aprobacion'=> $valor['fecha_pre_aprobacion'],
                   'fecha_aprobacion'=> $valor['fecha_aprobacion'],
                   'motivo'=> $valor['motivo'],
                   'observacion_pre_aprobacion'=> $valor['observacion_pre_aprobacion'],
                   'observacion_aprobacion'=> $valor['observacion_aprobacion'],
                   'motivo_baja'=> $valor['motivo_baja'],
                   'estado'=> $valor['estado']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function agregarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if(empty($verificarExistencia)){
                $guardar = $clasificacion->agregar($array);
                if($guardar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                }               
         
        }else{
            error("registro_existente");
        }
    }

    function obtenerDatosParaModificarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idfondo_para_rendicion'],
                   'fecha_carga'=> $valor['fecha_carga'],
                   'realizado_por'=> $valor['realizado_por'],
                   'otorgado_a'=> $valor['otorgado_a'],
                   'monto'=> $valor['monto'],
                   'pre_aprueba'=> $valor['pre_aprueba'],
                   'aprueba'=> $valor['aprueba'],
                   'fecha_pre_aprobacion'=> $valor['fecha_pre_aprobacion'],
                   'fecha_aprobacion'=> $valor['fecha_aprobacion'],
                   'motivo'=> $valor['motivo'],
                   'observacion_pre_aprobacion'=> $valor['observacion_pre_aprobacion'],
                   'observacion_aprobacion'=> $valor['observacion_aprobacion'],
                   'motivo_baja'=> $valor['motivo_baja'],
                   'estado'=> $valor['estado']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarMontoRendicionApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarMontoRendicion($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'monto'=> $valor['monto']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function modificarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if(empty($verificarExistencia)){
                $datos = array( 
                    'descripcion'=> $array['descripcion'],
                    'id'=> $array['id']
                );
                $editar = $clasificacion->modificar($datos);
                if($editar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                }          
        }else{
            $idRecogido = $verificarExistencia[0]['idcargo'];
            $idParaModificar = $array['id'];
            if($idRecogido != $idParaModificar){
                exito("repetido");
            }else{
                $editar = $clasificacion->modificar($datos);
                if($editar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                }
            }
        }
    }

    function actualizarEstadoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        if($array['estado'] == 'anulado'){
            $eliminar = $clasificacion->actualizarEstadoFondo($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
        }

        if($array['estado'] == 'pre aprobado'){
            $eliminar = $clasificacion->actualizarPreAprobacion($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
        }

        if($array['estado'] == 'aprobado'){
            $eliminar = $clasificacion->actualizarAprobacion($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
        }
        
    }

} //FIN API SESIONES

    function error($mensaje){
        echo json_encode(array('mensaje' => $mensaje)); 
    }

    function exito($mensaje){
        echo json_encode(array('mensaje' => $mensaje)); 
    }

    function printJSON($array){
        echo json_encode($array);
    }

?>