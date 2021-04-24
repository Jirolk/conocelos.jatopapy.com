<?php
     require_once("conexion.php");
    session_start();
      $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
     $valor= $_POST["id"];
     $sql = "SELECT categoria FROM categorias WHERE idcategoria = '$valor'";
     $res = pg_query($conex, $sql);
     $reg = pg_fetch_array($res);
       echo $reg['categoria'];
