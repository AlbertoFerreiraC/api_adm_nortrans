<?php

include_once 'sql.php';

class ApiControlador
{

    function listarHerramientasApi()
    {
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

    function agregarApi($array)
    {
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $datos = array(
                'empresa' => $array['empresa'],
                'proveedor' => $array['proveedor'],
                'solicitud_ms' => $array['solicitud_ms'],
                'doc_proveedor' => $array['doc_proveedor'],
                'num_doc_proveedor' => $array['num_doc_proveedor'],
                'plazo_oc' => $array['plazo_oc'],
                'pago_oc' => $array['pago_oc'],
                'plazo_entrega' => $array['plazo_entrega'],
                'tipo_doc_compra' => $array['tipo_doc_compra'],
                'pre_aprueba' => $array['pre_aprueba'],
                'nro_oc' => $array['nro_oc'],
                'fecha_creacion'   => date('Y-m-d H:i:s'),
                // Valores por defecto
                'sub_total'        => 0,
                'descuento_total'  => 0,
                'exento_total'     => 0,
                'neto_total'       => 0,
                'iva_total'        => 0,
                'retencion_total'  => 0,
                'total_general'    => 0
            );
            $guardar = $clasificacion->agregar($datos);
            if ($guardar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            error("registro_existente");
        }
    }

    function obtenerDatosParaModificarApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idclase_bus'],
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

    function modificarApi($array)
    {
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

    function aprobarApi($array)
    {
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


    function rechazarApi($array)
    {
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


    function eliminarApi($array)
    {
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
