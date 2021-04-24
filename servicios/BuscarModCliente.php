<?php
     require_once("conexion.php");
      session_start();
      $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
     $valor= $_POST["id"];
    //  $suc= $_POST["suc"];
     $sql = "SELECT * FROM clientes WHERE ruc = '$valor'";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
     $datos = $reg['ruc'].','.$reg['razon_social'].','.$reg['direccion'].','.$reg['telefono'].','.$reg['idciudad'];//concateno
     echo $datos;
   ?>
