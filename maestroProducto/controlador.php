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
                    'id' => $valor['idproducto'],
                    'categoria' => $valor['categoria'],
                    'sub_categoria' => $valor['sub_categoria'],
                    'unidad_de_medida' => $valor['unidad_de_medida'],
                    'descripcion' => $valor['descripcion'],
                    'stock_minimo' => $valor['stock_minimo'],
                    'tipo_producto' => $valor['tipo_producto'],
                    'estado' => $valor['estado'],
                    'idproducto' => $valor['idproducto'],
                    'unidad_medida' => $valor['unidad_medida']
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
                'categoria' => $array['categoria'],
                'sub_categoria' => $array['sub_categoria'],
                'unidad_de_medida' => $array['unidad_de_medida'],
                'descripcion' => $array['descripcion'],
                'stock_minimo' => $array['stock_minimo'],
                'tipo_producto' => $array['tipo_producto'],
                'unidad_medida' => $array['unidad_medida']
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
                    'id' => $valor['idproducto'],
                    'categoria' => $valor['categoria'],
                    'sub_categoria' => $valor['sub_categoria'],
                    'unidad_de_medida' => $valor['unidad_de_medida'],
                    'descripcion' => $valor['descripcion'],
                    'stock_minimo' => $valor['stock_minimo'],
                    'tipo_producto' => $valor['tipo_producto'],
                    'unidad_medida' => $valor['unidad_medida']
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
                'categoria' => $array['categoria'],
                'sub_categoria' => $array['sub_categoria'],
                'unidad_de_medida' => $array['unidad_de_medida'],
                'descripcion' => $array['descripcion'],
                'stock_minimo' => $array['stock_minimo'],
                'tipo_producto' => $array['tipo_producto'],
                'unidad_medida' => $array['unidad_medida'],
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
