<?php
    require_once("../servicios/conexion.php");
    $conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
    $sql = "SELECT max(idcolor) as cod FROM colores";
    $rs = pg_query($conex, $sql);
    $reg = pg_fetch_array($rs);
        echo $reg['cod'];
?>

