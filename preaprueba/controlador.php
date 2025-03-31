<?php

include_once 'sql.php';

class ApiControlador
{

    function listarHerramientasApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarHerramientas($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idcontratacion' => $valor['idcontratacion'],
                    'cargo' => $valor['cargo'],
                    'empresa' => $valor['empresa'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'turnos_laborales' => $valor['turnos_laborales'],
                    'tipo_bus' => $valor['tipo_bus'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'aprueba' => $valor['aprueba'],
                    'motivo' => $valor['motivo'],
                    'tipo_contrato' => $valor['tipo_contrato'],
                    'division' => $valor['division'],
                    'cantidad_solicitada' => $valor['cantidad_solicitada'],
                    'licencia_de_conducir' => $valor['licencia_de_conducir'],
                    'fecha_requerida' => $valor['fecha_requerida'],
                    'fecha_termino' => $valor['fecha_termino'],
                    'remuneracion' => $valor['remuneracion'],
                    'comentario_general' => $valor['comentario_general'],
                    'estado' => 'activo',
                    'observacionEntrevistaPsicolaboral' => $valor['entrevista_psicolaboral'],
                    'observacionEntrevistaTecnica' => $valor['entrevista_tecnica'],
                    'observacionPruebaConduccion' => $valor['entrevista_conduccion']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarPreApruebaApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarPreApruebaApi($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idcontratacion' => $valor['idcontratacion'],
                    'cargo' => $valor['cargo'],
                    'empresa' => $valor['empresa'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'division' => $valor['division'],
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
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $guardar = $clasificacion->agregar($array);
            if ($guardar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
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
            $idRecogido = $verificarExistencia[0]['idcontratacion'];
            $idParaModificar = $array['idcontratacion'];
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
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $editar = $clasificacion->aprobar($array);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idcontratacion'];
            $idParaModificar = $array['idcontratacion'];
            if ($idRecogido != $idParaModificar) {
                exito("repetido");
            } else {
                $editar = $clasificacion->aprobar($array);
                if ($editar == "ok") {
                    exito("ok");
                } else {
                    exito("nok");
                }
            }
        }
    }

    function rechazarApi($array)
    {
        $clasificacion = new Sql();
        $eliminar = $clasificacion->rechazar($array);
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
