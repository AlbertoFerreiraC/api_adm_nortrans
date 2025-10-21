<?php

include_once 'sql.php';


class ApiControlador
{
    function listarSolicitudesAprobadasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarSolicitudesAprobadas();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idsms' => $valor['idsms'],
                    'descripcion' => $valor['descripcion']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function agregarCabeceraApi($array){
        $clasificacion = new Sql();
            $guardar = $clasificacion->agregarCabecera($array);
            if ($guardar == "ok") {
                $consulta = $clasificacion->verificarCabecera($array);
                if (!empty($consulta)) {
                  exito($consulta[0]['idgenerar_oc']);
                }else{
                  exito("nok");  
                }                
            } else {
                exito("nok");
            }
    }

    function funModificarCabeceraApi($array){
        $clasificacion = new Sql();
        if($array['codigoAjunto'] != "Sin Archivo"){
            $actualizar = $clasificacion->modificarCabeceraCompleto($array);
            if ($actualizar == "ok") {
                exito($array['id']);               
            } else {
                exito("nok");
            }
        }else{
            $actualizar = $clasificacion->modificarCabeceraSinImagen($array);
            if ($actualizar == "ok") {
                exito($array['id']);               
            } else {
                exito("nok");
            }
        }
            
    }

    function agregarDetalleApi($array){
        $clasificacion = new Sql();
                $clasificacion->eliminarDetalle($array);
                foreach ($array['tabla']as $clave => $valor) {
                    $datosDetalle = array( 
                        'nroOc'=> $array['idOc'],
                        'nroSms'=> $valor->nroSms,
                        'nroSmsDetalle'=> $valor->nroSmsDetalle,
                        'itemSms'=> $valor->itemSms,
                        'aplicacion'=> $valor->aplicacion,
                        'tipoProducto'=> $valor->tipoProducto,
                        'glosa'=> $valor->glosa,
                        'unidadDeMedida'=> $valor->unidadDeMedida,
                        'cantidad'=> $valor->cantidad,
                        'costoUnitario'=> $valor->costoUnitario,
                        'tipoDescuento'=> $valor->tipoDescuento,
                        'valorDescuento'=> $valor->valorDescuento,
                        'subTotal'=> $valor->subTotal,
                        'estado'=> $valor->estado
                    );
                    $clasificacion->agregarDetalle($datosDetalle);
                }    
                exito("ok");              
    }


    //*************************************************/

    function listarHerramientasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarHerramientas();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idgenerar_oc'],
                    'fecha_creacion' => $valor['fecha_creacion'],
                    'fecha_pre_aprobacion' => $valor['fecha_pre_aprobacion'],
                    'fecha_aprobacion' => $valor['fecha_aprobacion'],
                    'empresa' => $valor['empresa'],
                    'proveedor' => $valor['proveedor'],
                    'doc_proveedor' => $valor['doc_proveedor'],
                    'plazo_oc' => $valor['plazo_oc'],
                    'pago_oc' => $valor['pago_oc'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'tipo_oc' => $valor['tipo_oc'],
                    'num_doc_proveedor' => $valor['num_doc_proveedor'],
                    'plazo_entrega' => $valor['plazo_entrega'],
                    'tipo_documento_compra' => $valor['tipo_documento_compra'],
                    'sub_total' => $valor['sub_total'],
                    'descuento_total' => $valor['descuento_total'],
                    'exento_total' => $valor['exento_total'],
                    'neto_total' => $valor['neto_total'],
                    'iva_total' => $valor['iva_total'],
                    'retencion_total' => $valor['retencion_total'],
                    'total_general' => $valor['total_general'],
                    'observacion_aprueba' => $valor['observacion_aprueba'],
                    'estado' => $valor['estado']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarOCActivasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarOCActivas();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idgenerar_oc'],
                    'fecha_creacion' => $valor['fecha_creacion'],
                    'empresa' => $valor['empresa'],
                    'proveedor' => $valor['proveedor'],
                    'tipo_oc' => $valor['tipo_oc'],
                    'plazo_entrega' => $valor['plazo_entrega'],
                    'total_general' => $valor['total_general']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function obtenerDatosParaModificarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idgenerar_oc'          => $valor['idgenerar_oc'],
                    'fecha_creacion'        => $valor['fecha_creacion'],
                    'fecha_pre_aprobacion'  => $valor['fecha_pre_aprobacion'],
                    'fecha_aprobacion'      => $valor['fecha_aprobacion'],
                    'empresa'               => $valor['empresa'],
                    'proveedor'             => $valor['proveedor'],
                    'doc_proveedor'         => $valor['doc_proveedor'],
                    'plazo_oc'              => $valor['plazo_oc'],
                    'pago_oc'               => $valor['pago_oc'],
                    'pre_aprueba'           => $valor['pre_aprueba'],
                    'pre_aprueba2'          => $valor['pre_aprueba2'],
                    'tipo_oc'               => $valor['tipo_oc'],
                    'num_doc_proveedor'     => $valor['num_doc_proveedor'],
                    'plazo_entrega'         => $valor['plazo_entrega'],
                    'tipo_documento_compra' => $valor['tipo_documento_compra'],
                    'sub_total'             => $valor['sub_total'],
                    'descuento_total'       => $valor['descuento_total'],
                    'exento_total'          => $valor['exento_total'],
                    'neto_total'            => $valor['neto_total'],
                    'iva_total'             => $valor['iva_total'],
                    'retencion_total'       => $valor['retencion_total'],
                    'total_general'         => $valor['total_general'],
                    'observacion_aprueba'   => $valor['observacion_aprueba'],
                    'referencia_adjunto'    => $valor['referencia_adjunto'],
                    'tipo_adjunto'          => $valor['tipo_adjunto'],
                    'estado'                => $valor['estado']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarDetalleOCParaEditarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarDetalleOCParaEditar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['iddetalle_oc'],
                    'generar_oc' => $valor['generar_oc'],
                    'sms' => $valor['sms'],
                    'detalle_sms' => $valor['detalle_sms'],
                    'nro_item' => $valor['nro_item'],
                    'aplicacion' => $valor['aplicacion'],
                    'tipo_producto' => $valor['tipo_producto'],
                    'glosa' => $valor['glosa'],
                    'unidad_de_medida' => $valor['unidad_de_medida'],
                    'cantidad' => $valor['cantidad'],
                    'costo_unitario' => $valor['costo_unitario'],
                    'tipo_descuento' => $valor['tipo_descuento'],
                    'valor_descuento' => $valor['valor_descuento'],
                    'sub_total' => $valor['sub_total'],
                    'estado' => $valor['estado']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function modificarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $datos = array(
                'descripcion' => $array['descripcion'],
                'id' => $array['id']
            );
            $editar = $clasificacion->modificar($datos);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idclase_bus'];
            $idParaModificar = $array['id'];
            if ($idRecogido != $idParaModificar) {
                exito("repetido");
            } else {
                $editar = $clasificacion->modificar($array);
                if ($editar == "ok") {
                    exito("ok");
                } else {
                    exito("nok");
                }
            }
        }
    }

    function aprobarApi($array){
        $clasificacion = new Sql();

        if (!isset($array['id']) || empty($array['id'])) {
            exito("nok");
            return;
        }

        $editar = $clasificacion->aprobar($array);
        if ($editar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }


    function rechazarApi($array){
        $clasificacion = new Sql();

        if (!isset($array['id']) || empty($array['id'])) {
            exito("nok");
            return;
        }

        $editar = $clasificacion->rechazar($array);
        if ($editar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }

    function eliminarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminar($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }
} //FIN API SESIONES

function error($mensaje)
{
    echo json_encode(array('mensaje' => $mensaje));
}

function exito($mensaje)
{
    echo json_encode(array('mensaje' => $mensaje));
}

function printJSON($array)
{
    echo json_encode($array);
}
