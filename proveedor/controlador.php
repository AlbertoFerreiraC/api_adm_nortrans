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
                    'id' => $valor['idproveedor'],
                    'comuna' => $valor['comuna'],
                    'condicion_de_pago' => $valor['condicion_de_pago'],
                    'tipo_de_proveedor' => $valor['tipo_de_proveedor'],
                    'descripcion' => $valor['descripcion'],
                    'rut' => $valor['rut'],
                    'telefono_contacto' => $valor['telefono_contacto'],
                    'correo_contacto' => $valor['correo_contacto'],
                    'direccion' => $valor['direccion'],
                    'criticidad' => $valor['criticidad']
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
                'comuna' => $array['comuna'],
                'condicion_de_pago' => $array['condicion_de_pago'],
                'tipo_de_proveedor' => $array['tipo_de_proveedor'],
                'descripcion' => $array['descripcion'],
                'rut' => $array['rut'],
                'telefono_contacto' => $array['telefono_contacto'],
                'correo_contacto' => $array['correo_contacto'],
                'direccion' => $array['direccion'],
                'criticidad' => $array['criticidad']
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
                    'id' => $valor['idproveedor'],
                    'comuna' => $valor['comuna'],
                    'condicion_de_pago' => $valor['condicion_de_pago'],
                    'tipo_de_proveedor' => $valor['tipo_de_proveedor'],
                    'descripcion' => $valor['descripcion'],
                    'rut' => $valor['rut'],
                    'telefono_contacto' => $valor['telefono_contacto'],
                    'correo_contacto' => $valor['correo_contacto'],
                    'direccion' => $valor['direccion'],
                    'criticidad' => $valor['criticidad']
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
                'comuna' => $array['comuna'],
                'condicion_de_pago' => $array['condicion_de_pago'],
                'tipo_de_proveedor' => $array['tipo_de_proveedor'],
                'descripcion' => $array['descripcion'],
                'rut' => $array['rut'],
                'telefono_contacto' => $array['telefono_contacto'],
                'correo_contacto' => $array['correo_contacto'],
                'direccion' => $array['direccion'],
                'direccion' => $array['direccion'],
                'id' => $array['id']
            );
            $editar = $clasificacion->modificar($datos);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idproveedor'];
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
