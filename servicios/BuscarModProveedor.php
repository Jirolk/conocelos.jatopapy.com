<?php
     require_once("conexion.php");
      session_start();
      $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
     $valor= $_POST["id"];
     $sql = "SELECT * FROM proveedores WHERE ruc = '$valor'";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
     $datos = $reg['razon_social'].','.$reg['telefono'].','.$reg['direccion'].','.$reg['contacto'].','.$reg['ruc'].','.$reg['idciudad'];//concateno
     echo $datos;
   ?>
