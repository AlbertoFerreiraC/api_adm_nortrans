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
                   'id'=> $valor['idpersonal'],
                   'rut'=> $valor['rut'],
                   'nombre'=> $valor['nombre'].' '.$valor['apellido'],
                   'estado_civil'=> $valor['estado_civil'],
                   'telefono_empresa'=> $valor['telefono_empresa'],
                   'telefono_propio'=> $valor['telefono_propio'],
                   'email'=> $valor['email'],
                   'email_empresa'=> $valor['email_empresa'],
                   'imagen'=> 'vistas/img/personal/'.$valor['nombre_foto_perfil'].'.jpg'
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
            if($array['contieneImagen'] == 'si'){
                unlink('../../adm-nortrans/vistas/img/personal/'.$array['nombreImagen'].'.jpg');
            }            
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
                   'id'=> $valor['idpersonal'],
                   'nacionalidad'=> $valor['nacionalidad'],
                   'comuna'=> $valor['comuna'],
                   'afp'=> $valor['afp'],
                   'salud'=> $valor['salud'],
                   'empresa'=> $valor['empresa'],
                   'centro_de_costo'=> $valor['centro_de_costo'],
                   'turnos_laborales'=> $valor['turnos_laborales'],
                   'rut'=> $valor['rut'],
                   'nombre'=> $valor['nombre'],
                   'apellido'=> $valor['apellido'],
                   'estado_civil'=> $valor['estado_civil'],
                   'fecha_nacimiento'=> $valor['fecha_nacimiento'],
                   'genero'=> $valor['genero'],
                   'direccion'=> $valor['direccion'],
                   'telefono_empresa'=> $valor['telefono_empresa'],
                   'telefono_propio'=> $valor['telefono_propio'],
                   'email'=> $valor['email'],
                   'email_empresa'=> $valor['email_empresa'],
                   'contiene_foto_perfil'=> $valor['contiene_foto_perfil'],
                   'nombre_foto_perfil'=> $valor['nombre_foto_perfil'],
                   'imagen'=> 'vistas/img/personal/'.$valor['nombre_foto_perfil'].'.jpg'
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
                $editar = $clasificacion->modificar($array);
                if($editar == "ok"){
                    if($array['contieneImagen'] == "si"){
                        unlink('../../adm-nortrans/vistas/img/personal/'.$verificarExistencia[0]['nombre_foto_perfil'].'.jpg');
                        $item = array(
                            'id'=> $array['id'],
                            'nombre_foto_perfil'=> $array['nombreImagen']
                        );                        
                        $clasificacion->actualizarImagen($item);
                        exito("ok");
                    }else{
                        exito("ok");
                    }
                    
                }else{
                    exito("nok");
                }          
        }else{
            $idRecogido = $verificarExistencia[0]['idpersonal'];
            $idParaModificar = $array['id'];
            if($idRecogido != $idParaModificar){
                exito("repetido");
            }else{
                $editar = $clasificacion->modificar($array);
                if($editar == "ok"){
                    if($array['contieneImagen'] == "si"){
                        unlink('../../adm-nortrans/vistas/img/personal/'.$verificarExistencia[0]['nombre_foto_perfil'].'.jpg');
                        $item = array(
                            'id'=> $array['id'],
                            'nombre_foto_perfil'=> $array['nombreImagen']
                        );                        
                        $clasificacion->actualizarImagen($item);
                        exito("ok");
                    }else{
                        exito("ok");
                    }
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