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
                   'id_contratacion'=> $valor['id_contratacion'],
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

    //***********************************************

    function cargaAsignacionlaboralApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargaAsignacionlaboral($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listaAsignacioneslaboralesApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listaAsignacioneslaborales($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'idasignacion_laboral'=> $valor['idasignacion_laboral'],
                   'division'=> $valor['division'],
                   'empresa'=> $valor['empresa'],
                   'centro_de_costo'=> $valor['centro_de_costo']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function eliminarAsignacionLaboralApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarAsignacionlaboral($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }


    function cargarDocumentoLaboral($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarDocumentoLaboral($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listaDocumentosLaboralesApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listaDocumentoslaborales($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'iddocumentos_laborales'=> $valor['iddocumentos_laborales'],
                   'descripcion_documento'=> $valor['descripcion_documento'],
                   'id_docu'=> $valor['id_docu'],
                   'fecha_vencimiento'=> $valor['fecha_vencimiento'],
                   'tipo_adjunto'=> $valor['tipo_adjunto'],
                   'id_personal'=> $valor['id_personal'],
                   'id_documento'=> $valor['id_documento']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function eliminarDocumentosLaboralesApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarDocumentoLaboral($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarEstudioCursado($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarEstudioCursado($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listaEstudiosCursadosApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listaEstudiosCursados($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'idestudios'=> $valor['idestudios'],
                   'id_personal'=> $valor['id_personal'],
                   'id_tipo_estudio'=> $valor['id_tipo_estudio'],
                   'descripcion_tipo_estudio'=> $valor['descripcion_tipo_estudio'],
                   'estado_estudio'=> $valor['estado_estudio'],
                   'tipo_adjunto'=> $valor['tipo_adjunto']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function eliminarEstudiosCursadosApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarEstudiosCursados($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarTallaApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarTalla($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listartallasApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarTallas($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'idmedidas'=> $valor['idmedidas'],
                   'tipo_epp'=> $valor['tipo_epp'],
                   'nro_talla'=> $valor['nro_talla']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function eliminarTallaApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarTalla($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarContactoEmergencia($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarContactoEmergencia($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listarContactosDeEmergencia($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarContactosDeEmergencia($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'idcontacto_emergencia'=> $valor['idcontacto_emergencia'],
                   'nombre'=> $valor['nombre'],
                   'telefono'=> $valor['telefono'],
                   'parentezco'=> $valor['parentezco']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function eliminarContactoDeEmergencia($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarContactoDeEmergencia($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function cargarAntecedenteMedicoApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->cargarAntecedenteMedico($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    function listaAntecedentesApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->listaAntecedentes($array);      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'idantecedentes'=> $valor['idantecedentes'],
                   'descripcion'=> $valor['descripcion'],
                   'detalle'=> $valor['detalle']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function eliminarAntecedentesMedicosApi($array){
        $clasificacion = new Sql();
        //********************************************************************    
        $eliminar = $clasificacion->eliminarAntecedentesMedicos($array);
                if($eliminar == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
    }

    //----------------------------------

    function listarSolicitudesDeContratosApi(){
        $clasificacion = new Sql();
        $lista = $clasificacion->listarSolicitudesDeContrato();      
        $listaArr = array();
        if(!empty($lista)){
            foreach ($lista as $clave => $valor) {
                $item = array(
                   'idcontratacion'=> $valor['idcontratacion'],
                   'cargo'=> $valor['cargo'],
                   'centro'=> $valor['centro'],
                   'requerido'=> $valor['requerido']
               );
               array_push($listaArr, $item);               
           }
           printJSON($listaArr);
        }else{
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    } 

    function actualizarContratoApi($array){
        $clasificacion = new Sql();
        $lista = $clasificacion->consultaFichaContrato($array);    
        if(!empty($lista)){
            $item = array(
                'idFicha'=> $lista[0]['idficha_contrato'],
                'contratacion'=> $array['idContratacion']
            );
            $actualizarFicha = $clasificacion->actualizarFichaContrato($item);
                if($actualizarFicha == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
        }else{
            $datosContratacion = $clasificacion->listarDatosContratacion($array);  
            $item = array(
                'personal'=> $array['idEmpleado'],
                'contratacion'=> $array['idContratacion'],
                'empresa'=> $datosContratacion[0]['empresa'],
                'cargo'=> $datosContratacion[0]['cargo'],
                'turnos_laborales'=> $datosContratacion[0]['turnos_laborales'],
                'division'=> $datosContratacion[0]['division'],
                'tipo_contrato'=> $datosContratacion[0]['tipo_contrato'],
                'sueldo_liquido'=> $datosContratacion[0]['remuneracion']
            ); 
            $cargarFicha = $clasificacion->cargarFichaContrato($item);
                if($cargarFicha == "ok"){
                    exito("ok");
                }else{
                    exito("nok");
                } 
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