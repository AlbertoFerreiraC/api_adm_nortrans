<?php

include_once 'sql.php';

class ApiControlador
{

    function listarContratadoApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarContratado();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idcontratacion' => $valor['idcontratacion'],
                    'idficha_contrato' => $valor['idficha_contrato'],
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
                    'observacionPruebaConduccion' => $valor['entrevista_conduccion'],
                    'cantidad_contratada' => $valor['cantidad_contratada'],
                    'usuario' => $valor['realizado_por'],
                    'fecha_inicio_laboral' => $valor['fecha_inicio_laboral']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function cambiarEstadoContratoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cambiarEstadoContrato($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function modificarApi($array){
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

    function obtenerDatosParaModificarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'rut' => $valor['rut'],
                    'nombre_completo' => $valor['nombre_completo'],
                    'telefono_propio' => $valor['telefono_propio'],
                    'idficha_contrato' => $valor['idficha_contrato'],
                    'contratacion' => $valor['contratacion'],
                    'descripcion_empresa' => $valor['descripcion_empresa'],
                    'id_empresa' => $valor['id_empresa'],
                    'division' => $valor['division'],
                    'cargo' => $valor['cargo'],
                    'tipo_contrato' => $valor['tipo_contrato'],
                    'turno' => $valor['turno'],
                    'fecha_inicio' => $valor['fecha_inicio'],
                    'sueldo_liquido' => $valor['sueldo_liquido'],
                    'documento_contrato' => $valor['documento_contrato'],
                    'tipo_documento_contrato' => $valor['tipo_documento_contrato']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function actualizarDatosFichaContratoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->actualizarDatosFichaContrato($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    //-----------------------------------------------------------

    function actualizarDocumentoContratoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->actualizarDocumentosContrato($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarRequisitoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarRequisito($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listarRequisitosDeFichaApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarRequisitosDeFicha($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id_detalle' => $valor['id_detalle'],
                    'id_ficha' => $valor['id_ficha'],
                    'id_requisito' => $valor['id_requisito'],
                    'requisito' => $valor['requisito'],
                    'observacion' => $valor['observacion'],
                    'tipo_adjunto' => $valor['tipo_adjunto']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function eliminarRequisitoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarRequisito($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarAnexoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarAnexo($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listarAnexosDeFichaApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarAnexosDeFicha($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id_detalle' => $valor['id_detalle'],
                    'id_ficha' => $valor['id_ficha'],
                    'idtipo_anexo' => $valor['idtipo_anexo'],
                    'descripcion_anexo' => $valor['descripcion_anexo'],
                    'fecha' => $valor['fecha'],
                    'observacion' => $valor['observacion'],
                    'tipo_adjunto' => $valor['tipo_adjunto']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function eliminarAnexoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarAnexo($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }
} //FIN 
// 
// API SESIONES

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
