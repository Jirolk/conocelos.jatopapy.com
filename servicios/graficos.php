<?php
session_start();
require_once("conexion.php");
$conex = conexion($_SESSION["nombreUsuario"], $_SESSION["pass"]);
$sql = "SELECT * FROM insumos" ;
$res = pg_query($conex, $sql);
// $reg = pg_fetch_array($res);
$row[]=array();
while ($row=pg_fetch_assoc($res)){
        $insumos[]= array(
            'descri' => $row['descripcion'],
            'stock' => $row['stock']
        );
}

// $datos = $reg['descripcion'].','.$reg['unidad_med'].','.$reg['idcategoria'].','.$reg['idcolor'].','.$reg['conversion'].','.$reg['stock'].','.$reg['precompra'];
// echo $datos;
echo json_encode($insumos);
// print_r(json_encode($insumos));
// echo $insumos;


?>