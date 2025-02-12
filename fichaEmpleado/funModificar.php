<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $nombreImagen = "";
    $contieneImagen = "no";
    if ( empty($_FILES['imagen']['tmp_name']) != 1) {
        date_default_timezone_set('America/Asuncion');
	    $nombreImagen = date("Ymd_his"); // Y PARA CARPETA
        $Imagen =  file_get_contents($_FILES['imagen']['tmp_name']);
        $filename = $nombreImagen.'.jpg'; 
        $bytes = file_put_contents('../../adm-nortrans/vistas/img/personal/'.$filename, $Imagen);
        $contieneImagen = "si";
    }
    $item = array(
        'id' => $_POST['id'],
        'rut' => $_POST['rut'],
        'fechaNacimiento' => $_POST['fechaNacimiento'],
        'genero' => $_POST['genero'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'nacionalidad' => $_POST['nacionalidad'],
        'estadoCivil' => $_POST['estadoCivil'],
        'comuna' => $_POST['comuna'],
        'direccion' => $_POST['direccion'],
        'telefonoEmpresa' => $_POST['telefonoEmpresa'],
        'emailEmpresa' => $_POST['emailEmpresa'],
        'telefonoPropio' => $_POST['telefonoPropio'],
        'emailPersonal' => $_POST['emailPersonal'],
        'afp' => $_POST['afp'],
        'salud' => $_POST['salud'],
        'empresa' => $_POST['empresa'],
        'centro' => $_POST['centro'],
        'turno' => $_POST['turno'],
        'contieneImagen' => $contieneImagen,
        'nombreImagen' => $nombreImagen
    );
    $api -> modificarApi($item);
?>