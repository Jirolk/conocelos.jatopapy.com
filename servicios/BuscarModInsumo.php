<?php
     require_once("conexion.php");
     session_start();
     $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
     $valor= $_POST["id"];
     $sql = "SELECT * FROM insumos WHERE idinsumo = '$valor'";
     $res = pg_query($conex, $sql);

     
     $reg = pg_fetch_array($res);
     $datos = $reg['descripcion'].','.$reg['unidad_med'].','.$reg['idcategoria'].','.$reg['idcolor'].','.$reg['conversion'].','.$reg['stock'].','.$reg['precompra'];
     echo $datos;
?>