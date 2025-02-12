<?php

include_once 'sql.php';

class ApiControlador{
   
    function listarHerramientasApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarHerramientas();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idcentro_de_costo'],
                   'descripcion'=> $valor['centro_de_costo'],
                   'empresa'=> $valor['empresa']
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
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if(empty($verificarExistencia)){
                $guardar = $clasificacion->agregar($array);
                if($guardar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                }               
         
        }else{
            error("registro_existente");
        }
    }

    function obtenerDatosParaModificarApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'id'=> $valor['idcentro_de_costo'],
                   'descripcion'=> $valor['centro_de_costo'],
                   'nombreEmpresa'=> $valor['empresa'],
                   'idempresa'=> $valor['idempresa']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function listadoDeCentroDeCostoPorEmpresa($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listadoDeCentroDeCostoPorEmpresa($array);      
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

    function modificarApi($array){
        $clasificacion = new Sql();
        //********************************************************************   
        $datos = array( 
            'descripcion'=> $array['descripcion'],
            'empresa'=> $array['empresa'],
            'id'=> $array['id']
        ); 
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if(empty($verificarExistencia)){
                
                $editar = $clasificacion->modificar($datos);
                if($editar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                }          
        }else{
            $idRecogido = $verificarExistencia[0]['idcentro_de_costo'];
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

    function eliminarApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminar($array);
                if($eliminar == "ok"){
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