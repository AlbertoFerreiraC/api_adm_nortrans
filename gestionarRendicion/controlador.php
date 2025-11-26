<?php

include_once 'sql.php';

class ApiControlador{

    function listarFechaApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarFecha();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
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

    function listarCentroDeCosto(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarCentroDeCosto();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idcentro_de_costo'],
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
   
    function listarMisRendiciones($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarMisRendiciones($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idrendiciones'],
                   'usuario'=> $valor['usuario'],
                   'dependendia'=> $valor['dependendia'],
                   'saldo_inicial'=> $valor['saldo_inicial'],
                   'monto_rendido'=> $valor['monto_rendido'],
                   'saldo'=> number_format($valor['saldo'], 0, ',', '.'),
                   'comentario_adicional'=> $valor['comentario_adicional'],
                   'estado'=> $valor['estado'],
                   'fecha'=> $valor['fecha'],
                   'contiene_adjunto'=> $valor['contiene_adjunto'],
                   'tipo_adjunto'=> $valor['tipo_adjunto']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarRendiciones($array){
        $clasificacion = new Sql();        
        $estado = "";
        if($array['estado'] == "pendiente"){
            $estado = " and ren.estado = 'pendiente' ";
        }
        if($array['estado'] == "en revision"){
            $estado = " and ren.estado = 'en revision' ";
        }
        if($array['estado'] == "procesado"){
            $estado = " and ren.estado = 'procesado' ";
        }
        if($array['estado'] == "rechazado"){
            $estado = " and ren.estado = 'rechazado' ";
        }
        $datos = array(
                   'estado'=> $estado,
                   'usuario'=> $array['usuario']
               );
        $lista = $clasificacion->listarRendiciones($datos);         
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idrendiciones'],
                   'usuario'=> $valor['usuario'],
                   'dependendia'=> $valor['dependendia'],
                   'saldo_inicial'=> $valor['saldo_inicial'],
                   'monto_rendido'=> $valor['monto_rendido'],
                   'saldo'=> $valor['saldo'],
                   'comentario_adicional'=> $valor['comentario_adicional'],
                   'estado'=> $valor['estado'],
                   'fecha'=> $valor['fecha'],
                   'contiene_adjunto'=> $valor['contiene_adjunto'],
                   'tipo_adjunto'=> $valor['tipo_adjunto']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarcabeceraRendicion($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarCabeceraRendicion($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idrendiciones'],
                   'usuario'=> $valor['usuario'],
                   'dependendia'=> $valor['dependendia'],
                   'iddependencia'=> $valor['iddependencia'],
                   'saldo_inicial'=> $valor['saldo_inicial'],
                   'monto_rendido'=> $valor['monto_rendido'],
                   'saldo'=> number_format($valor['saldo'], 0, ',', '.'),
                   'comentario_adicional'=> $valor['comentario_adicional'],
                   'comentario_revision'=> $valor['comentario_revision'],
                   'estado'=> $valor['estado'],
                   'fecha'=> $valor['fecha'],
                   'contiene_adjunto'=> $valor['contiene_adjunto'],
                   'tipo_adjunto'=> $valor['tipo_adjunto']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listarDetalleRendicion($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarDetalleRendicion($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['iddetalle_rendicion'],
                   'proveedor'=> $valor['proveedor'],
                   'centro_de_costo'=> $valor['centro_de_costo'],
                   'fecha'=> $valor['fecha'],
                   'tipo'=> $valor['tipo'],
                   'nro_documento'=> $valor['nro_documento'],
                   'monto'=> $valor['monto'],
                   'detalle'=> $valor['detalle'],
                   'maquina'=> $valor['maquina']
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
            $guardar = $clasificacion->agregarCabecera($array);
            if($guardar == "ok"){
                $idRendicion = $clasificacion->idRendicion();
                foreach ($array['tabla']as $clave => $valor) {
                    $datosID = array( 'proveedor'=> $valor->proveedor, 'centroDeCosto'=> $valor->centroDeCosto);
                    $idProveedor = $clasificacion->idproveedor($datosID);
                    $idCentro = $clasificacion->idcentro($datosID);
                    
                    $datosDetalle = array( 
                        'fecha'=> $valor->fecha,
                        'tipo'=> $valor->tipo,
                        'nroDocumento'=> $valor->nroDocumento,
                        'monto'=> $valor->monto,
                        'detalle'=> $valor->detalle,
                        'maquina'=> $valor->maquina,
                        'centroDeCosto'=> $idCentro[0]['idcentro_de_costo'],
                        'proveedor'=> $idProveedor[0]['idproveedor'],
                        'idRendicion'=> $idRendicion[0]['id']
                    );
                    $clasificacion->agregarDetalle($datosDetalle);
                }    
                exito($idRendicion[0]['id']);
            }else{
                exito("nok");
            }               
    }

    function agregarItemApi($array){
        $clasificacion = new Sql();
            $guardar = $clasificacion->agregarItemRendicion($array);
            if($guardar == "ok"){
                $lista = $clasificacion->listarCabeceraRendicion($array);       
                $saldoInicial = intval($lista[0]['saldo_inicial']); 
                $montoRendido = intval($lista[0]['monto_rendido']) + intval($array['monto']); 
                $saldo = $saldoInicial - $montoRendido;
                $item = array(
                   'id'=> $array['id'],
                   'monto_rendido'=> $montoRendido,
                   'saldo'=> $saldo 
                );
                $clasificacion->actualizarCabeceraRendicion($item);  
                exito("ok");
            }else{
                exito("nok");
            }               
    }


    function obtenerDatosParaModificarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idtipo_epp'],
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
            $idRecogido = $verificarExistencia[0]['idtipo_epp'];
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

    function eliminarItem($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarItemRendicion($array);
                if($eliminar == "ok"){
                    $lista = $clasificacion->listarCabeceraRendicion($array);  
                    $listaMonto = $clasificacion->listarMontoRendido($array);       
                    $saldoInicial = intval($lista[0]['saldo_inicial']); 
                    $montoRendido = intval($listaMonto[0]['monto']); 
                    $saldo = $saldoInicial - $montoRendido;
                    $item = array(
                    'id'=> $array['id'],
                    'monto_rendido'=> $montoRendido,
                    'saldo'=> $saldo 
                    );
                    $clasificacion->actualizarCabeceraRendicion($item); 
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function actualizarEstado($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->actualizarEstadoRendicion($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarDocumentoRendicion($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargaDocumentoRendicion($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function consultarNroDocumentoApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->consultarNroFactura($array);      
        $listaArr = array();
        if(empty($lista)){
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