<?php

include_once 'sql.php';

class ApiControlador{
   
    function listarMaquinasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarMaquinas();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idmaquina'],
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

    function listarTipoTareaApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarTipoTarea();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idtipo_tarea_mantencion'],
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

    function listarSistemaApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarSistema();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idsistema_maquina'],
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

    function listarSubSistemaApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarSubSistema();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idsub_sistema_maquina'],
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

    function listarPersonalTecnicoApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarPersonalTecnico();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idpersonal_tecnico'],
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

    function listarRepuestosApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarRepuestos();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idrepuestos'],
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

    function procesarCabeceraApi($array){
        $clasificacion = new Sql();
                $guardar = $clasificacion->procesarCabecera($array);
                if($guardar == "ok"){
                    $id = $clasificacion->ultimoId();
                    exito($id[0]['id']);
                }else{
                    exito("nok");
                }               
    }

    function procesarDetalleTareaApi($array){
        $clasificacion = new Sql();
                foreach ($array['tabla']as $clave => $valor) {
                    $datosDetalle = array( 
                        'idOt'=> $array['idOt'],
                        'tipoTarea'=> $valor->tipoTarea,
                        'sistema'=> $valor->sistema,
                        'subSistema'=> $valor->subSistema,
                        'tecnico'=> $valor->tecnico,
                        'observacion'=> $valor->observacion,
                        'fechaHoraTarea'=> $valor->fechaHoraTarea
                    );
                    $clasificacion->procesarDetalleTarea($datosDetalle);
                }    
                exito("ok");              
    }

    function procesarDetalleRepuestoApi($array){
        $clasificacion = new Sql();
                foreach ($array['tabla']as $clave => $valor) {
                    $datosDetalle = array( 
                        'idOt'=> $array['idOt'],
                        'repuesto'=> $valor->repuesto,
                        'cantidadRepuesto'=> $valor->cantidadRepuesto
                    );
                    $clasificacion->procesarDetalleRepuesto($datosDetalle);
                }    
                exito("ok");              
    }

    function listarOtsGeneradasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarOtsGeneradas();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idot_interna'],
                   'descripcion'=> "OT: ".$valor['idot_interna']." En Fecha: ".$valor['fecha']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function obtenerDatosCabeceraApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosCabecera($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idot_interna'      => $valor['idot_interna'],
                    'usuario'           => $valor['usuario'],
                    'maquina'           => $valor['maquina'],
                    'centro_de_costo'   => $valor['centro_de_costo'],
                    'fecha'             => $valor['fecha'],
                    'km_actual'         => $valor['km_actual'],
                    'estado'            => $valor['estado']
                );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function modificarCabeceraApi($array){
        $clasificacion = new Sql();
                $guardar = $clasificacion->modificarCabecera($array);
                if($guardar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                }               
    }


    function listarTareasDeOtApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarTareasDeOt($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                'idtareas_ot'          => $valor['idtareas_ot'],
                'ot_interna'           => $valor['ot_interna'],
                'personal_tecnico'     => $valor['personal_tecnico'],
                'tipo_tarea_mantencion'=> $valor['tipo_tarea_mantencion'],
                'sistema_maquina'      => $valor['sistema_maquina'],
                'sub_sistema_maquina'  => $valor['sub_sistema_maquina'],
                'fecha'                => $valor['fecha'],
                'observacion'          => $valor['observacion'],
                'estado'               => $valor['estado'],
                'personal_nombre'      => $valor['personal_nombre'],
                'tipo_nombre'          => $valor['tipo_nombre'],
                'sistema_nombre'       => $valor['sistema_nombre'],
                'sub_nombre'           => $valor['sub_nombre']
            );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function eliminarTareaApi($array){
        $clasificacion = new Sql();
                $guardar = $clasificacion->eliminarTarea($array);
                if($guardar == "ok"){
                   exito("ok");
                }else{
                    exito("nok");
                }               
    }

    function listarRepuestosOtApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarRepuestosOt($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                'idrepuestos_solicitados'          => $valor['idrepuestos_solicitados'],
                'descripcion_repuesto'           => $valor['descripcion'],
                'cantidad'     => $valor['cantidad']
            );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function eliminarRepuestoApi($array){
        $clasificacion = new Sql();
                $guardar = $clasificacion->eliminarRepuesto($array);
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