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
                    'rut' => $valor['rut'],
                    'personal' => $valor['personal'],
                    'tipo_documento' => $valor['tipo_documento'],
                    'fecha_expiracion' => $valor['fecha_expiracion'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
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
