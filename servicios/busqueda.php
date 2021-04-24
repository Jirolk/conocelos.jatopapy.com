<?php
     require_once("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"],$_SESSION["pass"]);
     $criterio= $_POST["criterio"];
     $valor= $_POST["valor"];
     $busqueda= $_POST["busqueda"];
     $tabla = $_POST["tabla"];
     if($tabla == "proveedores"){
       $sql = "SELECT ".$busqueda." FROM ".$tabla." WHERE ".$criterio." =  '$valor'";
       $res = pg_query($conex, $sql);
       $reg = pg_fetch_array($res);
       echo $reg[$busqueda];
     }else if($tabla == "reservas"){
       $sql = "SELECT Entrega, Precio, Descuento FROM reservas WHERE Id_reserva = '$valor'";
       $res = pg_query($conex, $sql);
       $reg = pg_fetch_array($res);
       $datos = $reg['Entrega'].','.$reg['Precio'].','.$reg['Descuento'];//concateno
       echo $datos;
     }else if($tabla == "insumo" && $busqueda == "Id"){
       $sql = "SELECT Id_insumo FROM Insumo WHERE Insumo = '$valor' ";
       $res = pg_query($conex, $sql);
       $reg = pg_fetch_array($res);
       echo $reg['Id_insumo'];
    }elseif ($tabla== "insumo" && $busqueda == "ajustestock") {
      $sql = "SELECT Insumo FROM insumo WHERE Id_insumo = '$valor' AND Cod_sucursal=".$_SESSION["Cod_sucursal"];
      $res = pg_query($conex, $sql);
      $reg = pg_fetch_array($res);
      echo $reg['Insumo'];
     }elseif ($tabla== "insumos" && $busqueda == "stock") {
          $sql = "SELECT stock FROM insumos WHERE idinsumo = '$valor'";
          $res = pg_query($conex, $sql);
          $reg = pg_fetch_array($res);
          echo $reg['stock'];
     }elseif($tabla=="insumos" && $busqueda == "descripcion"){
       $sql = "SELECT descripcion, precompra, iva, stock FROM insumos WHERE idinsumo = '$valor'";
       $res = pg_query($conex, $sql);
       $reg = pg_fetch_array($res);
       $datos = $reg['descripcion'].','.$reg['precompra'].','.$reg['iva'];//concateno
       echo $datos;
  }elseif($tabla=="insumos" && $busqueda == "conversion"){
    $sql = "SELECT descripcion, precompra, conversion, stock FROM insumos WHERE idinsumo = '$valor'";
    $res = pg_query($conex, $sql);
    $reg = pg_fetch_array($res);
    $datos = $reg['descripcion'].','.$reg['precompra'].','.$reg['conversion'];//concateno
    echo $datos;
}else if($tabla=="funcionario" && $busqueda == "Razon_social"){
          $sql = "SELECT Razon_social FROM funcionario WHERE CI_func = '$valor' AND Cod_sucursal=".$_SESSION["Cod_sucursal"];
          $res = pg_query($conex, $sql);
          $reg = pg_fetch_array($res);
          echo $reg['Razon_social'];
     }else if($tabla == "caja_detalle"){
      $sql = "SELECT ".$busqueda." FROM ".$tabla." WHERE ".$criterio." =  '$valor' group by 2 order by 1 desc";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
     $datos = $reg['fec'].','.$reg['idusuario'];//concateno
     echo $datos;
    }else{
      $sql = "SELECT ".$busqueda." FROM ".$tabla." WHERE ".$criterio." =  '$valor' ";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
       echo $reg[$busqueda];
    }
   ?>
