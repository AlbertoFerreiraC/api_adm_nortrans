<?php

include_once 'sql.php';

class ApiControlador{
   
    function listarConductoresApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarConductores();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idconductor'],
                   'descripcion'=> $valor['nombre']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function procesarCabeceraApi($array){
        $clasificacion = new Sql();
            $guardar = $clasificacion->procesarCabecera($array);
                if($guardar == "ok"){
                   $id = $clasificacion->idReporte();
                    exito($id[0]['id']);
                }else{
                    exito("nok");
                }               
    }

    function procesarDetalleApi($array){
        $clasificacion = new Sql();
                foreach ($array['tabla']as $clave => $valor) {
                    $datosDetalle = array( 
                        'idFalla'=> $array['idFalla'],
                        'sistema'=> $valor->sistema,
                        'subSistema'=> $valor->subSistema,
                        'observacion'=> $valor->observacion
                    );
                    $clasificacion->procesarDetalle($datosDetalle);
                }    
                exito("ok");              
    }

    function listaReporteFallaApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listaReporteFalla();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idreporte_falla'],
                   'conductor'=> $valor['conductor'],
                   'maquina'=> $valor['maquina'],
                   'kmReportado'=> $valor['km_reportado'],
                   'fecha'=> $valor['fecha']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 


    function obtenerDatosParaModificarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idreporte_falla'],
                   'conductor'=> $valor['conductor'],
                   'maquina'=> $valor['maquina'],
                   'kmReportado'=> $valor['km_reportado'],
                   'fecha'=> $valor['fecha']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function obtenerDetalleFallaApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDetalleFallas($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['iddetalle_reporte_falla'],
                   'sistema'=> $valor['sistema'],
                   'sub_sistema'=> $valor['sub_sistema'],
                   'observacion'=> $valor['observacion']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function modificarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->modificar($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }


    function eliminarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminar($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function eliminarFallaApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarFalla($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
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