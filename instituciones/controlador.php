<?php

include_once 'sql.php';

class ApiControlador
{

    function listarHerramientas($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarHerramientas($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idinstitucion'],
                    'tipo_institucion' => $valor['tipo_institucion'],
                    'descripcion' => $valor['descripcion'],
                    'codigo_externo' => $valor['codigo_externo'],
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

    function listarInstitucionsApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarHerramientas($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idinstitucion' => $valor['idinstitucion'],
                    'tipo_institucion' => $valor['tipo_institucion'],
                    'descripcion' => $valor['descripcion'],
                    'codigo_externo' => $valor['codigo_externo'],
                    'estado' => 'activo',
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
        $tipo_institucion = new Sql();
        //********************************************************************    
        $verificarExistencia = $tipo_institucion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $datos = array(
                'tipo_institucion' => $array['tipo_institucion'],
                'descripcion' => $array['descripcin'],
                'codigo_externo' => $array['codigo_externo']
            );
            $guardar = $tipo_institucion->agregar($datos);
            if ($guardar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            error("registro_existente");
        }
    }

    function modificarApi($array)
    {
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $editar = $clasificacion->modificar($array);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idinstitucion'];
            $idParaModificar = $array['idinstitucion'];
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
