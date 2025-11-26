<?php

include_once 'sql.php';

class ApiControlador{
   
    function listarBodegas(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarBodegas();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idde_bodega'],
                   'descripcion'=> $valor['descripcion']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarServiciosApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarServicios();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id'=> $valor['id'],
                    'descripcion'=> $valor['descripcion'],
                    'cantidad_por_unidad'=> $valor['cantidad_por_unidad'],
                    'unidad_de_medida'=> $valor['unidad_de_medida'],
                    'cantidad_en_bodega'=> $valor['cantidad_en_bodega']
                );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarEppApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarEpp();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id'=> $valor['id'],
                    'descripcion'=> $valor['descripcion'],
                    'cantidad_por_unidad'=> $valor['cantidad_por_unidad'],
                    'unidad_de_medida'=> $valor['unidad_de_medida'],
                    'cantidad_en_bodega'=> $valor['cantidad_en_bodega']
                );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarInsumosApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarInsumos();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id'=> $valor['id'],
                    'descripcion'=> $valor['descripcion'],
                    'cantidad_por_unidad'=> $valor['cantidad_por_unidad'],
                    'unidad_de_medida'=> $valor['unidad_de_medida'],
                    'cantidad_en_bodega'=> $valor['cantidad_en_bodega']
                );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarRepuestosApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarRepuestos();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id'=> $valor['id'],
                    'descripcion'=> $valor['descripcion'],
                    'cantidad_por_unidad'=> $valor['cantidad_por_unidad'],
                    'unidad_de_medida'=> $valor['unidad_de_medida'],
                    'cantidad_en_bodega'=> $valor['cantidad_en_bodega']
                );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function obtenerDatosEspecificosApi($array){
        $clasificacion = new Sql();
        $lista = null;
        if($array['tipo'] != "Repuesto"){
            $lista = $clasificacion->listarDatosEspecificosProductos($array); 
        }else{
            $lista = $clasificacion->listarDatosEspecificosRepuestos($array); 
        }             
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id'=> $valor['id'],
                    'descripcion'=> $valor['descripcion'],
                    'cantidad_por_unidad'=> $valor['cantidad_por_unidad'],
                    'unidad_de_medida'=> $valor['unidad_de_medida'],
                    'cantidad_en_bodega'=> $valor['cantidad_en_bodega']
                );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function generarSolicitudApi($array){
        $clasificacion = new Sql();
            $guardar = null;
            if($array['maquina'] != "null"){
                $guardar = $clasificacion->agregarCabecera($array);
            }else{
                $guardar = $clasificacion->agregarCabeceraSinMaquina($array);
            }
                if($guardar == "ok"){
                    $idSolicitud = $clasificacion->maxIdSolicitud();
                    foreach ($array['tabla']as $clave => $valor) {
                        $producto = null;
                        $repuesto = null;
                        if($valor->tipo == "Repuesto"){ 
                            $repuesto = $valor->producto;
                        }else{ 
                            $producto = $valor->producto; 
                        }
                        $datosDetalle = array( 
                            'producto'=> $producto,
                            'repuesto'=> $repuesto,
                            'tipo'=> $valor->tipo,
                            'unidadDeMedida'=> $valor->unidadDeMedida,
                            'centroDeCosto'=> $valor->centroDeCosto,
                            'cantidad'=> $valor->cantidad,
                            'aplicacion'=> $valor->aplicacion,
                            'idSolicitud'=> $idSolicitud[0]['id']
                        );   
                        if($valor->tipo == "Repuesto"){ 
                            $clasificacion->agregarDetalleSinProducto($datosDetalle);
                        }else{ 
                            $clasificacion->agregarDetalleSinRepuesto($datosDetalle);
                        }
                    }
                    exito($idSolicitud[0]['id']);
                }else{
                    exito("nok");
                }
    }

    function listarSolicitudesActivasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarSolicitudesActivas();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idsms'],
                   'empresa'=> $valor['empresa'],
                   'bodega'=> $valor['bodga'],
                   'preAprueba'=> $valor['pre_aprueba'],
                   'fecha'=> $valor['fecha'],
                   'tipo'=> $valor['tipo'],
                   'observacion'=> $valor['observacion'],
                   'realizadoPor'=> $valor['realizado']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }
    
    function listarDatosDeSmsApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarDatosDeSms($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idsms'],
                   'bodega'=> $valor['bodega'],
                   'empresa'=> $valor['empresa'],
                   'maquina'=> $valor['maquina'],
                   'preAprueba'=> $valor['pre_aprueba'],
                   'tipo'=> $valor['tipo'],
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

    function listarDatosDetalleDeSmsApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarDatosDetalleSms($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $controlDatos = array(
                   'idDetalle'=> $valor['iddetalle_sms'],
                );   
                $listaControl = $clasificacion->controlVistaDetalleSms($controlDatos);   
                if(empty($listaControl)){
                    $item = array(
                        'idDetalle'=> $valor['iddetalle_sms'],
                        'centroDeCosto'=> $valor['centro_de_costo'],
                        'repuestos'=> $valor['repuestos'],
                        'insumos'=> $valor['insumos'],
                        'tipo'=> $valor['tipo'],
                        'unidad_de_medida'=> $valor['unidad_de_medida'],
                        'cantidad'=> $valor['cantidad'],
                        'aplicacion'=> $valor['aplicacion'],
                        'nombreCentrDeCosto'=> $valor['nombre_centro_de_costo'],
                        'descripcionRepuestos'=> $valor['descripcion_repuestos'],
                        'descripcionInsumos'=> $valor['descripcion_insumos']
                    );
                    array_push($listaArr, $item); 
                }                              
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function actualizarCantidadApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->actualizarCantidadProducto($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function elimminarProducto($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarProducto($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function agregarItemModificar($array){
        $clasificacion = new Sql();
                        $producto = null;
                        $repuesto = null;
                        if($array['tipo'] == "Repuesto"){ 
                            $repuesto = $array['producto'];
                        }else{ 
                            $producto = $array['producto'];
                        }
                        $datosDetalle = array( 
                            'producto'=> $producto,
                            'repuesto'=> $repuesto,
                            'tipo'=> $array['tipo'],
                            'unidadDeMedida'=> $array['unidadDeMedida'],
                            'centroDeCosto'=> $array['centroDeCosto'],
                            'cantidad'=> $array['cantidad'],
                            'aplicacion'=> $array['aplicacion'],
                            'idSolicitud'=> $array['idSms']
                        );   
                        if($array['tipo'] == "Repuesto"){ 
                            $clasificacion->agregarDetalleSinProducto($datosDetalle);
                        }else{ 
                            $clasificacion->agregarDetalleSinRepuesto($datosDetalle);
                        }
                    exito("ok");
    } 


    function actualizarSolicitud($array){
        $clasificacion = new Sql();
            $guardar = null;
            if($array['maquina'] != "null"){
                $guardar = $clasificacion->actualizarCabecera($array);
            }else{
                $guardar = $clasificacion->actualizarCabeceraSinMaquina($array);
            }
                if($guardar == "ok"){
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