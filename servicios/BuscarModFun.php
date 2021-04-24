<?php
     require_once("conexion.php");
     $conex = conexion();
     $valor= $_POST["id"];
    //  $suc= $_POST["suc"];
     $sql = "SELECT * FROM funcionarios WHERE ci_funcionario='$valor'";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
     $datos = $reg['ci_funcionario'].','.$reg['razon_social'].','.$reg['telefono'].','.$reg['direccion'];//concateno
     echo $datos;
   ?>
