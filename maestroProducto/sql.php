<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    try {
      $query = $this->connect()->prepare("SELECT pro.idproducto,
                                            cat.descripcion AS categoria,
                                            suc.descripcion AS sub_categoria,
                                            udm.descripcion AS unidad_de_medida,
                                            pro.descripcion,
                                            pro.stock_minimo,
                                            pro.estado,
                                            pro.tipo_producto,
                                            pro.unidad_medida
                                            FROM producto pro
                                            JOIN categoria cat ON cat.idcategoria = pro.categoria
                                            JOIN sub_categoria suc ON suc.idsub_categoria = pro.sub_categoria
                                            JOIN unidad_de_medida udm ON udm.idunidad_de_medida = pro.unidad_de_medida
                                            WHERE pro.estado = 'activo'");
      $query->execute();
      return $query->fetchAll();
    } catch (PDOException $e) {
      error_log("Error en listarHerramientas: " . $e->getMessage());
      return null;
    }
  }


  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from proveedor where estado = 'activo' and 
        descripcion = :descripcion");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO producto (categoria, sub_categoria, unidad_de_medida, descripcion, stock_minimo, estado, tipo_producto, unidad_medida) VALUES (:categoria, :sub_categoria, :unidad_de_medida, :descripcion, :stock_minimo, 'activo', :tipo_producto, :unidad_medida);");

    $query->bindParam(":categoria", $item['categoria'], PDO::PARAM_STR);
    $query->bindParam(":sub_categoria", $item['sub_categoria'], PDO::PARAM_STR);
    $query->bindParam(":unidad_de_medida", $item['unidad_de_medida'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":stock_minimo", $item['stock_minimo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_producto", $item['tipo_producto'], PDO::PARAM_STR);
    $query->bindParam(":unidad_medida", $item['unidad_medida'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from producto where estado = 'activo' and 
      idproducto = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE producto SET
                                        categoria = :categoria , 
                                        sub_categoria = :sub_categoria , 
                                        unidad_de_medida = :unidad_de_medida , 
                                        descripcion = :descripcion , 
                                        stock_minimo = :stock_minimo ,
                                        tipo_producto = :tipo_producto , 
                                        unidad_medida = :unidad_medida
                                        WHERE
                                        idproducto = :idproducto 
                                        AND estado = 'activo';");
    $query->bindParam(":categoria", $item['categoria'], PDO::PARAM_STR);
    $query->bindParam(":sub_categoria", $item['sub_categoria'], PDO::PARAM_STR);
    $query->bindParam(":unidad_de_medida", $item['unidad_de_medida'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":stock_minimo", $item['stock_minimo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_producto", $item['tipo_producto'], PDO::PARAM_STR);
    $query->bindParam(":unidad_medida", $item['unidad_medida'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update producto set estado = 'inactivo' where idproducto = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
